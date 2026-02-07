@extends('layouts.admin')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700 mb-6">Orders</h3>

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Invoice</th>
                    <th class="py-3 px-6 text-left">User</th>
                    <th class="py-3 px-6 text-center">Total</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Date</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($orders as $order)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <span class="font-medium">{{ $order->invoice_number }}</span>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <span>{{ $order->user->name }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span>Rp {{ number_format($order->total_price) }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span>{{ $order->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
