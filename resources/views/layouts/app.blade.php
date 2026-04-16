<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token để bảo vệ form chống tấn công giả mạo request -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Hệ thống Bán Lẻ - Đồ Án E-Commerce')</title>

    <!-- Directive của Vite để nạp CSS và JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased">

    <!-- Navbar: Dùng Alpine.js (x-data) để quản lý trạng thái menu mobile -->
    <header class="bg-brand-red text-white shadow-md sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wider">
                        My<span class="text-yellow-300">Store</span>
                    </a>
                </div>

                <!-- Thanh tìm kiếm (Giả lập) -->
                <div class="hidden md:flex flex-1 mx-8">
                    <input type="text" placeholder="Bạn cần tìm gì?" class="w-full rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                </div>

                <!-- Menu Phải (Giỏ hàng & Đăng nhập) -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('cart.index') }}" class="flex items-center hover:text-yellow-300 transition">
                        <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Giỏ hàng</span>
                        <!-- Đếm số lượng sản phẩm trong Session bằng Helper của Laravel -->
                        <span class="ml-1 bg-yellow-400 text-brand-dark text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ count(session('cart', [])) }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hiển thị Flash Message (Ví dụ: Thêm giỏ hàng thành công) -->
    <!-- Alpine.js x-data x-show giúp tự động ẩn thông báo sau 3 giây -->
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
             x-transition.duration.500ms
             class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    <!-- Nội dung chính của từng trang sẽ được nhúng vào đây -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Đồ án E-Commerce. MVC Architecture By Sinh Viên CNTT.
        </div>
    </footer>

</body>
</html>
