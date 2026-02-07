@extends('layouts.app')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700 mb-6">My Orders</h3>

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Invoice</th>
                    <th class="py-3 px-6 text-center">Date</th>
                    <th class="py-3 px-6 text-center">Total</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($orders as $order)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium">
                        {{ $order->invoice_number }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        {{ $order->created_at->format('d M Y') }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        Rp {{ number_format($order->total_price) }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs uppercase font-bold">{{ $order->status }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('my-orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6">You have no orders yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
