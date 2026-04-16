<!-- Kế thừa layout gốc -->
@extends('layouts.app')

<!-- Đặt title cho trang -->
@section('title', 'Trang chủ - MyStore')

<!-- Bắt đầu phần nội dung chính -->
@section('content')

    <!-- Banner Section -->
    <div class="bg-white rounded-xl shadow-sm mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-red-500 to-brand-red text-white p-8 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Đại Tiệc Công Nghệ</h1>
            <p class="text-lg opacity-90">Giảm giá cực sốc lên đến 50%. Chỉ trong tuần này!</p>
        </div>
    </div>

    <!-- Danh sách sản phẩm nổi bật -->
    <div class="mb-6 flex justify-between items-end">
        <h2 class="text-2xl font-bold text-gray-800 uppercase">Điện Thoại Nổi Bật</h2>
        <a href="#" class="text-blue-600 hover:underline text-sm">Xem tất cả ></a>
    </div>

    <!-- Grid Layout Responsive: Mobile 2 cột, Tablet 3 cột, PC 5 cột -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

        <!-- Vòng lặp Blade duyệt qua dữ liệu từ Controller -->
        @forelse($featuredProducts as $product)
            <!-- BƯỚC BẢO MẬT: Kiểm tra xem $product có đúng là Object (Model) không -->
            @if(is_object($product))
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-col hover:shadow-lg transition duration-300 transform hover:-translate-y-1">

                    <!-- Ảnh sản phẩm -->
                    <a href="{{ route('product.show', $product->slug) }}" class="mb-4">
                        <!-- Trong thực tế src sẽ là hàm asset('storage/' . $product->thumbnail) -->
                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded">
                    </a>

                    <!-- Thông tin sản phẩm -->
                    <div class="flex-1">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 hover:text-brand-red transition">
                                {{ $product->name }}
                            </h3>
                        </a>

                        <div class="mt-2">
                            <!-- Gọi hàm Accessor $product->is_on_sale -->
                            @if($product->is_on_sale)
                                <span class="text-brand-red font-bold text-lg block">{{ number_format($product->sale_price, 0, ',', '.') }} ₫</span>
                                <span class="text-gray-400 line-through text-sm">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                            @else
                                <span class="text-brand-red font-bold text-lg block">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                            @endif
                        </div>
                    </div>

                    <!-- Form Thêm vào giỏ hàng -->
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-brand-red hover:bg-red-700 text-white font-semibold py-2 rounded transition">
                            Mua ngay
                        </button>
                    </form>
                </div>
            @endif
        @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                Chưa có sản phẩm nào nổi bật.
            </div>
        @endforelse

    </div>

@endsection
