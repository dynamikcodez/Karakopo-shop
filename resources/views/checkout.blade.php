@extends('layouts.app')

@section('title', 'Checkout | Karakopo')

@section('content')
<div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Checkout</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Provide your delivery details and finalize your order via WhatsApp.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
    <form action="{{ route('checkout.store') }}" method="POST" class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start space-y-8 lg:space-y-0">
        @csrf
        
        <!-- Left Column: Delivery Details & Payment Method -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Notice Banner -->
            <div class="bg-green-50 border border-green-200 rounded-2xl p-4 sm:p-5 flex items-start space-x-3">
                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                </div>
                <div class="text-xs sm:text-sm text-green-900 leading-relaxed">
                    <strong class="font-bold">Fast WhatsApp Order Confirmation:</strong>
                    <p class="mt-0.5 text-green-800">
                        Online instant card payments are <strong>coming soon</strong>! For now, submit your delivery details below to generate your order number, then confirm via WhatsApp and pay via quick bank transfer.
                    </p>
                </div>
            </div>

            <!-- Customer & Delivery Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <span class="w-6 h-6 rounded-full bg-maroon text-white text-xs flex items-center justify-center mr-2">1</span>
                    Delivery Information
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', auth()->check() ? auth()->user()->name : '') }}" placeholder="e.g. Chioma Okonkwo" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                    </div>

                    <div>
                        <label for="customer_email" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', auth()->check() ? auth()->user()->email : '') }}" placeholder="name@example.com" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" placeholder="0801 234 5678" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="delivery_address" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Street Address <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="delivery_address" id="delivery_address" value="{{ old('delivery_address') }}" placeholder="e.g. 14 Admiralty Way, Lekki Phase 1" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                    </div>

                    <div>
                        <label for="city" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            City / Town <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" id="city" value="{{ old('city', 'Lagos') }}" placeholder="e.g. Ikeja" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                    </div>

                    <div>
                        <label for="state" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            State <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="state" id="state" value="{{ old('state', 'Lagos') }}" placeholder="e.g. Lagos" class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon" required>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="delivery_instructions" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1">
                            Special Delivery Instructions <span class="text-xs text-gray-400 font-normal">Optional</span>
                        </label>
                        <textarea name="delivery_instructions" id="delivery_instructions" rows="2" placeholder="e.g. Call before delivery, gate code is 1234..." class="w-full text-sm border border-gray-300 rounded-xl py-2.5 px-3.5 focus:border-maroon focus:ring-maroon">{{ old('delivery_instructions') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Payment Method Selection -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <span class="w-6 h-6 rounded-full bg-maroon text-white text-xs flex items-center justify-center mr-2">2</span>
                    Payment Method
                </h2>

                <div class="space-y-3">
                    <!-- WhatsApp Transfer Option (Active & Default) -->
                    <label class="flex items-start p-4 rounded-xl border-2 border-[#25D366] bg-green-50/50 cursor-pointer shadow-sm">
                        <input type="radio" name="payment_method" value="whatsapp" checked class="mt-1 text-green-600 focus:ring-green-500 h-4 w-4">
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-gray-900 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 fill-current text-green-600" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                                    Pay via Bank Transfer / Confirm on WhatsApp
                                </span>
                                <span class="text-[10px] bg-green-600 text-white font-black px-2 py-0.5 rounded-full uppercase">Instant</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1">
                                An order number will be generated, and you'll be redirected with your formatted order summary directly to WhatsApp to complete payment via bank transfer.
                            </p>
                        </div>
                    </label>

                    <!-- Online Card Payments (Coming Soon) -->
                    <div class="flex items-start p-4 rounded-xl border border-gray-200 bg-gray-50 opacity-75 select-none">
                        <input type="radio" disabled class="mt-1 text-gray-400 h-4 w-4 cursor-not-allowed">
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    Online Card & USSD Payment (Paystack)
                                </span>
                                <span class="text-[10px] bg-amber-500 text-white font-bold px-2 py-0.5 rounded-full uppercase">Coming Soon</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">
                                Instant debit card, USSD, and online bank payments are currently being integrated and will be available soon.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Summary & Action -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4">Order Items ({{ count($cart) }})</h2>
                
                <ul role="list" class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    @foreach($cart as $id => $item)
                        <li class="py-3 flex items-center justify-between gap-3">
                            <div class="flex items-center space-x-3 min-w-0">
                                <div class="w-12 h-12 rounded-xl bg-gray-50 flex-shrink-0 overflow-hidden border border-gray-200">
                                    <img src="{{ karakopo_image_url($item['image'] ?? null) }}" 
                                         onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-gray-900 truncate">{{ $item['name'] }}</h4>
                                    <p class="text-[11px] text-gray-500">Qty {{ $item['quantity'] }} × ₦{{ number_format($item['price'], 2) }}</p>
                                </div>
                            </div>
                            <div class="text-right whitespace-nowrap">
                                <span class="text-xs font-bold text-gray-900">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <dl class="space-y-3 border-t border-gray-100 pt-4 mt-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <dt>Subtotal</dt>
                        <dd class="font-semibold text-gray-900">₦{{ number_format($subtotal, 2) }}</dd>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <dt>Standard Delivery</dt>
                        <dd class="font-semibold text-gray-900">₦{{ number_format($deliveryFee, 2) }}</dd>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-3 text-base">
                        <dt class="font-bold text-gray-900">Total</dt>
                        <dd class="font-black text-xl text-maroon">₦{{ number_format($total, 2) }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <button type="submit" class="w-full py-4 px-6 rounded-xl font-black text-sm text-white bg-[#25D366] hover:bg-[#20ba59] shadow-lg hover:shadow-xl transition-all flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                        <span>Confirm Order on WhatsApp</span>
                    </button>
                    <p class="text-center text-xs text-gray-500 mt-3">
                        ⚡ Quick processing • Delivery within 24-48 hours
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
