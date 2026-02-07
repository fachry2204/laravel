@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Latest Products</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img class="w-full h-56 object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            <div class="p-4">
                <h3 class="text-xl font-bold">{{ $product->name }}</h3>
                <p class="text-gray-600 mt-2">Rp {{ number_format($product->price) }}</p>
                <a href="{{ route('product.detail', $product->slug) }}" class="mt-4 block w-full bg-blue-600 text-white text-center py-2 rounded">View Details</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection
