@extends('layouts.admin')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700 mb-6">Order Details</h3>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Order Info -->
        <div class="md:w-2/3">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <h4 class="text-xl font-bold mb-2">Invoice: {{ $order->invoice_number }}</h4>
                    <p class="text-gray-600">Date: {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p class="text-gray-600">Status: <span class="font-bold">{{ ucfirst($order->status) }}</span></p>
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

        <!-- Actions -->
        <div class="md:w-1/3">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h4 class="text-lg font-bold mb-4">Update Status</h4>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                            Order Status
                        </label>
                        <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status" name="status">
                            @foreach(['pending', 'paid', 'processing', 'shipping', 'completed', 'cancelled', 'expired'] as $status)
                                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full" type="submit">
                        Update Status
                    </button>
                </form>
            </div>
            
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                <h4 class="text-lg font-bold mb-4">Customer Info</h4>
                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Phone:</strong> {{ $order->user->phone ?? '-' }}</p>
                
                @if($order->user->phone)
                <div class="mt-4">
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $order->user->phone) }}?text=Hello%20{{ urlencode($order->user->name) }},%20regarding%20your%20order%20{{ $order->invoice_number }}..." target="_blank" class="block text-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        Contact via WhatsApp
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
