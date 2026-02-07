@extends('layouts.admin')

@section('content')
    <h3 class="text-3xl font-medium text-gray-700">Dashboard</h3>
    
    <div class="mt-4">
        <div class="flex flex-wrap -mx-6">
            <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">0</h4>
                        <div class="text-gray-500">New Orders</div>
                    </div>
                </div>
            </div>
            <div class="w-full px-6 sm:w-1/2 xl:w-1/3 mt-6 sm:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">0</h4>
                        <div class="text-gray-500">Products</div>
                    </div>
                </div>
            </div>
            <div class="w-full px-6 sm:w-1/2 xl:w-1/3 mt-6 xl:mt-0">
                <div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">0</h4>
                        <div class="text-gray-500">Users</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
