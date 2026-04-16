@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Giỏ hàng của bạn</h1>

    @if(count($cartItems) > 0)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 text-sm">
                    <tr>
                        <th class="py-3 px-4">Sản phẩm</th>
                        <th class="py-3 px-4 text-center">Số lượng</th>
                        <th class="py-3 px-4 text-right">Đơn giá</th>
                        <th class="py-3 px-4 text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($cartItems as $id => $item)
                        <tr>
                            <td class="py-4 px-4 flex items-center">
                                <img src="[https://via.placeholder.com/80?text=IMG](https://via.placeholder.com/80?text=IMG)" class="w-16 h-16 rounded border mr-4" alt="">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
                                    <button class="text-red-500 text-sm mt-1 hover:underline">Xoá</button>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <!-- Trong dự án thực tế, chỗ này sẽ là input number gọi Ajax update -->
                                <span class="font-medium bg-gray-100 px-3 py-1 rounded">{{ $item['quantity'] }}</span>
                            </td>
                            <td class="py-4 px-4 text-right text-gray-600">
                                {{ number_format($item['price'], 0, ',', '.') }} ₫
                            </td>
                            <td class="py-4 px-4 text-right font-bold text-brand-red">
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="bg-gray-50 p-6 border-t flex justify-end">
                <div class="w-full md:w-1/2 lg:w-1/3">
                    <div class="flex justify-between font-bold text-lg mb-4">
                        <span>Tổng tiền:</span>
                        <span class="text-brand-red">{{ number_format($totalPrice, 0, ',', '.') }} ₫</span>
                    </div>
                    <button class="w-full bg-brand-red text-white py-3 rounded-lg font-bold hover:bg-red-700 transition uppercase">
                        Tiến hành đặt hàng
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white p-12 rounded-xl shadow-sm text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <p class="text-gray-500 mb-6">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Tiếp tục mua sắm
            </a>
        </div>
    @endif
</div>
@endsection
