@extends('layouts.app')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700 mb-6">Shopping Cart</h3>

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Product</th>
                    <th class="py-3 px-6 text-center">Price</th>
                    <th class="py-3 px-6 text-center">Quantity</th>
                    <th class="py-3 px-6 text-center">Total</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @if(session('cart'))
                    @foreach(session('cart') as $id => $details)
                        <tr class="border-b border-gray-200 hover:bg-gray-100" data-id="{{ $id }}">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2">
                                        @if($details['image'])
                                            <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('storage/' . $details['image']) }}" />
                                        @else
                                            <span class="w-10 h-10 rounded-full bg-gray-300 block"></span>
                                        @endif
                                    </div>
                                    <span class="font-medium">{{ $details['name'] }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <span>Rp {{ number_format($details['price']) }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <input type="number" value="{{ $details['quantity'] }}" class="w-16 text-center border rounded update-cart" />
                            </td>
                            <td class="py-3 px-6 text-center">
                                <span>Rp {{ number_format($details['price'] * $details['quantity']) }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <button class="bg-red-500 text-white px-3 py-1 rounded remove-from-cart">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center py-6">Your cart is empty.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('home') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Continue Shopping</a>
        @if(session('cart'))
            <a href="{{ route('checkout.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Checkout</a>
        @endif
    </div>

    <script>
        // Simple script to handle updates and deletes via AJAX or Form
        // For now, let's assume standard form submission or implement basic JS
        // Since we didn't setup jQuery or Axios, we'll keep it simple
        
        const updateInputs = document.querySelectorAll('.update-cart');
        updateInputs.forEach(input => {
            input.addEventListener('change', function() {
                const id = this.closest('tr').getAttribute('data-id');
                const quantity = this.value;
                
                fetch('{{ route('cart.update') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id: id, quantity: quantity })
                }).then(response => window.location.reload());
            });
        });

        const removeButtons = document.querySelectorAll('.remove-from-cart');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                if(confirm("Are you sure?")) {
                    const id = this.closest('tr').getAttribute('data-id');
                    
                    fetch('{{ route('cart.destroy') }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ id: id })
                    }).then(response => window.location.reload());
                }
            });
        });
    </script>
@endsection
