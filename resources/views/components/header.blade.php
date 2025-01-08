<header class="text-black p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="logo"><a href="/" class="text-2xl font-bold">Victoria</a>
        </div>
        <nav class="space-x-4">
            <a href="/dashboard" class="hover:underline">Dashboard</a>
            <a href="/pos" class="hover:underline">Point of Sales</a>
            <a href="/transactions" class="hover:underline">Transactions</a>
            <a href="/inventory" class="hover:underline">Inventory</a>
        </nav>
        @if(Auth::check())
            <!-- Tampilkan Nama Akun -->
            <a href="#" class="text-gray-700">{{ Auth::user()->name }}</a>
        @else
            <!-- Tampilkan Tombol Login -->

            <div class="auth-links">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Login</a>
            </div>
        @endif
    </div>
</header>