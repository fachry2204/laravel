@extends('layouts.app')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700 mb-6">Checkout</h3>

    <div class="flex flex-col md:flex-row gap-6">
        <div class="md:w-2/3">
            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <h4 class="text-xl font-bold mb-4">Shipping Address</h4>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
                            Full Address
                        </label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address" name="address" rows="3" required></textarea>
                    </div>

                    <div class="flex mb-4 gap-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="province_id">
                                Province
                            </label>
                            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="province_id" name="province_id" required>
                                <option value="">Select Province</option>
                                <!-- Populate via JS -->
                            </select>
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="city_id">
                                City
                            </label>
                            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="city_id" name="city_id" required>
                                <option value="">Select City</option>
                            </select>
                        </div>
                    </div>

                    <h4 class="text-xl font-bold mb-4 mt-8">Shipping Service</h4>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="courier">
                            Courier
                        </label>
                        <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="courier" name="courier" required>
                            <option value="">Select Courier</option>
                            <option value="jne">JNE</option>
                            <option value="tiki">TIKI</option>
                            <option value="pos">POS Indonesia</option>
                        </select>
                    </div>

                    <h4 class="text-xl font-bold mb-4 mt-8">Payment Method</h4>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="payment_method">
                            Select Payment
                        </label>
                        <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="payment_method" name="payment_method" required>
                            <option value="MYBVA">Maybank Virtual Account</option>
                            <option value="PERMATAVA">Permata Virtual Account</option>
                            <option value="BNIVA">BNI Virtual Account</option>
                            <option value="BRIVA">BRI Virtual Account</option>
                            <option value="MANDIRIVA">Mandiri Virtual Account</option>
                            <option value="ALFAMART">Alfamart</option>
                            <option value="INDOMARET">Indomaret</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                    
                    <!-- Hidden inputs for calculated values -->
                    <input type="hidden" name="shipping_service" value="REG" />
                    <input type="hidden" name="shipping_cost" value="10000" /> <!-- Dummy cost -->

                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full mt-6" type="submit">
                        Place Order
                    </button>
                </div>
            </form>
        </div>

        <div class="md:w-1/3">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h4 class="text-xl font-bold mb-4">Order Summary</h4>
                <div class="flex justify-between mb-2">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format(collect(session('cart'))->sum(fn($i) => $i['price'] * $i['quantity'])) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Shipping</span>
                    <span>Rp 10,000</span> <!-- Dummy -->
                </div>
                <hr class="my-4">
                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span>Rp {{ number_format(collect(session('cart'))->sum(fn($i) => $i['price'] * $i['quantity']) + 10000) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
