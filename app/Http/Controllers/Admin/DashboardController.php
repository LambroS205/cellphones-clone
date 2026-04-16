<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang tổng quan (Dashboard) cho Admin
     */
    public function index()
    {
        // Tạm thời trả về view, ta sẽ truyền các biến thống kê (doanh thu, số đơn) vào đây sau
        return view('admin.dashboard');
    }
}
