<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;

Route::get('/', [StorefrontController::class, 'index'])->name('home');
Route::get('/shop', [StorefrontController::class, 'shop'])->name('shop');
Route::get('/product/{slug}', [StorefrontController::class, 'product'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/verify', [\App\Http\Controllers\CheckoutController::class, 'verify'])->name('checkout.verify');
Route::get('/checkout/success/{order_number}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dynamic SEO XML Sitemap
Route::get('/sitemap.xml', function () {
    $categories = \App\Models\Category::where('is_published', true)->get();
    $products = \App\Models\Product::where('is_published', true)->get();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $xml .= '<url><loc>' . url('/') . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
    $xml .= '<url><loc>' . url('/shop') . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';

    foreach ($categories as $cat) {
        $xml .= '<url><loc>' . route('shop', ['category' => $cat->slug]) . '</loc><lastmod>' . ($cat->updated_at ? $cat->updated_at->format('Y-m-d') : date('Y-m-d')) . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
    }
    foreach ($products as $prod) {
        $xml .= '<url><loc>' . route('product.show', $prod->slug) . '</loc><lastmod>' . ($prod->updated_at ? $prod->updated_at->format('Y-m-d') : date('Y-m-d')) . '</lastmod><changefreq>weekly</changefreq><priority>0.85</priority></url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('database/download', function () {
        $path = config('database.connections.sqlite.database');
        if (file_exists($path)) {
            return response()->download($path, 'karakopo-inventory-' . date('Y-m-d-His') . '.sqlite');
        }
        abort(404, 'Database file not found');
    })->name('database.download');
});
