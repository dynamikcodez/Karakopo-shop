<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales' => Order::where('payment_status', 'Paid')->sum('total'),
            'orders_count' => Order::count(),
            'pending_orders' => Order::where('order_status', 'Pending')->count(),
            'completed_orders' => Order::where('order_status', 'Delivered')->count(),
            'product_count' => Product::count(),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
        ];

        $recentOrders = Order::with('items')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
