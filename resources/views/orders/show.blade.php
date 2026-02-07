@extends('layouts.app')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700 mb-6">Order Details</h3>

    <div class="flex flex-col md:flex-row gap-6">
        <div class="md:w-2/3">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <h4 class="text-xl font-bold mb-2">Invoice: {{ $order->invoice_number }}</h4>
                    <p class="text-gray-600">Date: {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p class="text-gray-600">Status: <span class="font-bold">{{ ucfirst($order->status) }}</span></p>
                    <p class="text-gray-600">Payment Method: {{ $order->payment_channel }}</p>
                </div>

                <div class="mb-6">
                    <h4 class="text-lg font-bold mb-2">Items</h4>
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">Product</th>
                                <th class="px-4 py-2 text-center">Quantity</th>
                                <th class="px-4 py-2 text-right">Price</th>
                                <th class="px-4 py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->product->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $item->quantity }}</td>
                                <td class="border px-4 py-2 text-right">Rp {{ number_format($item->price) }}</td>
                                <td class="border px-4 py-2 text-right">Rp {{ number_format($item->price * $item->quantity) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-right font-bold">Subtotal</td>
                                <td class="border px-4 py-2 text-right">Rp {{ number_format($order->total_price - $order->shipping_cost) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-right font-bold">Shipping Cost</td>
                                <td class="border px-4 py-2 text-right">Rp {{ number_format($order->shipping_cost) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-right font-bold text-lg">Grand Total</td>
                                <td class="border px-4 py-2 text-right font-bold text-lg">Rp {{ number_format($order->total_price) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-2">Shipping Information</h4>
                    <p class="text-gray-700 whitespace-pre-line">{{ $order->shipping_address }}</p>
                    <p class="mt-2 text-gray-700"><strong>Courier:</strong> {{ $order->courier_name }} ({{ $order->courier_service }})</p>
                </div>
            </div>
        </div>

        <div class="md:w-1/3">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h4 class="text-lg font-bold mb-4">Need Help?</h4>
                <p class="mb-4">If you have any questions about this order, please contact our support.</p>
                <a href="https://wa.me/6281234567890?text=Hello,%20I%20have%20a%20question%20about%20my%20order%20{{ $order->invoice_number }}" target="_blank" class="block text-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Contact Admin via WhatsApp
                </a>
            </div>
        </div>
    </div>
@endsection
