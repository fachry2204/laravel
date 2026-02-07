@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-1/2">
            <img class="w-full rounded-lg shadow-lg" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        </div>
        <div class="md:w-1/2">
            <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
            <p class="text-2xl text-blue-600 font-bold mt-4">Rp {{ number_format($product->price) }}</p>
            <p class="text-gray-600 mt-4">{{ $product->description }}</p>
            
            <div class="mt-8">
                <button class="bg-blue-600 text-white px-8 py-3 rounded hover:bg-blue-700">Add to Cart</button>
            </div>
        </div>
    </div>
@endsection
