<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tokomasivers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <nav class="bg-white shadow">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <a class="text-xl font-bold text-gray-800" href="/">Tokomasivers</a>
                <div>
                    <a href="{{ route('home') }}" class="text-gray-800 mx-2">Home</a>
                    <a href="{{ route('cart.index') }}" class="text-gray-800 mx-2">
                        Cart 
                        @if(session('cart'))
                            <span class="bg-red-500 text-white rounded-full px-2 py-1 text-xs">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 mx-2">Admin Dashboard</a>
                        @else
                            <a href="{{ route('my-orders.index') }}" class="text-gray-800 mx-2">My Orders</a>
                        @endif
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-800 mx-2">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-800 mx-2">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>
</body>
</html>
