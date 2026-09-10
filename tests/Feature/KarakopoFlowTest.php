<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KarakopoFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user_can_browse_storefront_and_view_product(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Spend less. Buy more.');
        $response->assertSee('Karakopo');

        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('Shop Collection');

        $product = Product::first();
        $response = $this->get("/product/{$product->slug}");
        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('WhatsApp');
        $response->assertSee('Telegram');
    }

    public function test_user_can_add_to_cart_and_checkout(): void
    {
        $product = Product::first();

        // 1. Add to cart
        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $response->assertRedirect();
        $this->assertEquals(2, session('cart')[$product->id]['quantity']);

        // 2. View cart
        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertSee($product->name);

        // 3. Checkout
        $response = $this->get('/checkout');
        $response->assertStatus(200);

        // 4. Place order (via WhatsApp / Bank Transfer flow)
        $response = $this->post('/checkout', [
            'customer_name' => 'Chioma Okonkwo',
            'customer_email' => 'chioma@example.com',
            'customer_phone' => '08012345678',
            'delivery_address' => '12 Admiralty Way, Lekki Phase 1',
            'city' => 'Lagos',
            'state' => 'Lagos',
            'delivery_instructions' => 'Call upon arrival at gate',
            'payment_method' => 'whatsapp',
        ]);

        $order = Order::where('customer_email', 'chioma@example.com')->first();
        $this->assertNotNull($order);
        $response->assertRedirect(route('checkout.success', $order->order_number));

        // 5. Success page contains WhatsApp button & Bank details
        $successResponse = $this->get(route('checkout.success', $order->order_number));
        $successResponse->assertStatus(200);
        $successResponse->assertSee('Confirm on WhatsApp');
        $successResponse->assertSee('Direct Bank Transfer Details');
        $successResponse->assertSee('Online Card Payment Coming Soon');
    }


    public function test_admin_can_login_and_access_admin_panel(): void
    {
        // 1. Show login
        $response = $this->get('/login');
        $response->assertStatus(200);

        // 2. Submit credentials
        $response = $this->post('/login', [
            'email' => 'admin@karakopo.com',
            'password' => 'password',
        ]);
        $response->assertRedirect('/admin');

        // 3. Admin dashboard
        $response = $this->actingAs(User::where('is_admin', true)->first())->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Overview');

        // 4. Admin products index
        $response = $this->actingAs(User::where('is_admin', true)->first())->get('/admin/products');
        $response->assertStatus(200);
        $response->assertSee('Promo');

        // 5. Admin orders index
        $response = $this->actingAs(User::where('is_admin', true)->first())->get('/admin/orders');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_product_with_image(): void
    {
        Storage::fake('public');
        $admin = User::where('is_admin', true)->first();
        $category = Category::first();

        $image = UploadedFile::fake()->create('test_plate.jpg', 50, 'image/jpeg');

        $response = $this->actingAs($admin)->post('/admin/products', [
            'name' => 'Ceramic Salad Bowl',
            'category_id' => $category->id,
            'price' => 12500,
            'sale_price' => 9500,
            'stock' => 25,
            'short_description' => 'Elegantly handcrafted ceramic salad bowl.',
            'description' => 'Made with high grade clay, perfect for modern Nigerian dinner tables.',
            'is_published' => '1',
            'is_featured' => '1',
            'images' => [$image],
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Ceramic Salad Bowl',
            'price' => 12500,
            'sale_price' => 9500,
            'stock' => 25,
        ]);

        $product = Product::where('name', 'Ceramic Salad Bowl')->first();
        $this->assertNotNull($product);
        $this->assertTrue($product->images()->count() > 0);
    }

    public function test_admin_can_view_order_and_update_status(): void
    {
        $admin = User::where('is_admin', true)->first();

        $order = Order::create([
            'order_number' => 'ORD-TEST1234',
            'customer_name' => 'Emeka Okafor',
            'customer_email' => 'emeka@example.com',
            'customer_phone' => '08099887766',
            'delivery_address' => 'Plot 5, Victoria Island',
            'city' => 'Lagos',
            'state' => 'Lagos',
            'subtotal' => 25000,
            'delivery_fee' => 3000,
            'total' => 28000,
            'payment_status' => 'Pending',
            'order_status' => 'Pending',
        ]);

        // View order
        $response = $this->actingAs($admin)->get("/admin/orders/{$order->id}");
        $response->assertStatus(200);
        $response->assertSee('ORD-TEST1234');
        $response->assertSee('Emeka Okafor');

        // Update order status
        $response = $this->actingAs($admin)->patch("/admin/orders/{$order->id}/status", [
            'order_status' => 'Shipped',
            'payment_status' => 'Paid',
        ]);
        $response->assertRedirect();

        $order->refresh();
        $this->assertEquals('Shipped', $order->order_status);
        $this->assertEquals('Paid', $order->payment_status);
    }
}
