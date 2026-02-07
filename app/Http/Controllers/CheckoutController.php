<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\RajaOngkirService;
use App\Services\TripayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $rajaOngkir;
    protected $tripay;

    public function __construct(RajaOngkirService $rajaOngkir, TripayService $tripay)
    {
        $this->rajaOngkir = $rajaOngkir;
        $this->tripay = $tripay;
    }

    public function index()
    {
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->route('home');
        }

        // In a real app, we would fetch provinces from API here
        // $provinces = $this->rajaOngkir->getProvinces();
        $provinces = []; // Placeholder

        return view('checkout.index', compact('cart', 'provinces'));
    }

    public function getCities(Request $request)
    {
        $cities = $this->rajaOngkir->getCities($request->province_id);
        return response()->json($cities);
    }

    public function getShippingCost(Request $request)
    {
        // Calculate total weight
        $cart = session()->get('cart');
        $weight = 0;
        foreach ($cart as $item) {
            $weight += $item['weight'] * $item['quantity'];
        }

        $cost = $this->rajaOngkir->getCost($request->destination, $weight, $request->courier);
        return response()->json($cost);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'courier' => 'required',
            'shipping_service' => 'required', // service code e.g., JNE REG
            'shipping_cost' => 'required|numeric',
            'payment_method' => 'required' // e.g., MYBVA (Maybank Virtual Account)
        ]);

        $user = Auth::user();
        $cart = session()->get('cart');
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $grandTotal = $totalPrice + $request->shipping_cost;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . time() . '-' . Str::random(5),
                'status' => 'pending',
                'total_price' => $grandTotal,
                'shipping_cost' => $request->shipping_cost,
                'courier_service' => $request->shipping_service,
                'courier_name' => $request->courier,
                'payment_channel' => $request->payment_method,
                'shipping_address' => $request->address // simplified, should store city/prov details too
            ]);

            $orderItems = [];
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                $orderItems[] = [
                    'sku' => $id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ];
            }

            // Request Tripay Transaction
            $tripayResponse = $this->tripay->requestTransaction(
                $request->payment_method,
                $order->invoice_number, // Use invoice as merchant ref
                $grandTotal,
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '08123456789'
                ],
                $orderItems
            );

            if ($tripayResponse['success']) {
                $order->update([
                    'payment_ref' => $tripayResponse['data']['reference'],
                    // 'snap_token' => $tripayResponse['data']['checkout_url'] // or similar
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully! Please complete payment.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }
}
