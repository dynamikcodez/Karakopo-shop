<!-- Admin Onboarding & User Guide Modal -->
<div id="onboarding-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="closeOnboardingModal()"></div>

    <div class="flex min-h-full items-center justify-center p-3 sm:p-6">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-4xl border border-gray-100">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-[#5B1032] to-[#7a1543] p-5 sm:p-6 text-white flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-xl shadow-inner">
                        🎓
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-black tracking-tight" id="modal-title">Karakopo Admin Onboarding & Guide</h3>
                        <p class="text-xs text-white/80 mt-0.5">Everything you need to know to manage products, market on WhatsApp, and fulfill orders.</p>
                    </div>
                </div>
                <button type="button" onclick="closeOnboardingModal()" class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-colors focus:outline-none" aria-label="Close modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Tab Navigation -->
            <div class="border-b border-gray-200 bg-gray-50/80 px-4 sm:px-6 flex overflow-x-auto gap-2 py-2 text-xs font-bold scrollbar-none">
                <button type="button" onclick="switchGuideTab('tab-products')" id="btn-tab-products" class="guide-tab-btn px-3 py-2 rounded-lg transition-all text-maroon bg-white shadow-sm border border-gray-200">
                    📦 1. Products & Stock
                </button>
                <button type="button" onclick="switchGuideTab('tab-promo')" id="btn-tab-promo" class="guide-tab-btn px-3 py-2 rounded-lg transition-all text-gray-600 hover:text-gray-900 hover:bg-white/60">
                    📢 2. WhatsApp Promo
                </button>
                <button type="button" onclick="switchGuideTab('tab-orders')" id="btn-tab-orders" class="guide-tab-btn px-3 py-2 rounded-lg transition-all text-gray-600 hover:text-gray-900 hover:bg-white/60">
                    💳 3. Orders & OPay
                </button>
                <button type="button" onclick="switchGuideTab('tab-whatsapp')" id="btn-tab-whatsapp" class="guide-tab-btn px-3 py-2 rounded-lg transition-all text-gray-600 hover:text-gray-900 hover:bg-white/60">
                    💬 4. WhatsApp Checkout
                </button>
                <button type="button" onclick="switchGuideTab('tab-developer')" id="btn-tab-developer" class="guide-tab-btn px-3 py-2 rounded-lg transition-all text-gray-600 hover:text-gray-900 hover:bg-white/60">
                    ❤️ 5. Your Son / Tech Support
                </button>
            </div>

            <!-- Tab Contents -->
            <div class="p-5 sm:p-7 max-h-[68vh] overflow-y-auto space-y-6 text-gray-700 text-sm">
                
                <!-- Tab 1: Products & Stock -->
                <div id="tab-products" class="guide-content-panel space-y-4">
                    <div class="flex items-center space-x-2 text-maroon font-bold text-base">
                        <span>📦</span>
                        <h4>How to Add & Manage Catalog Products</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200/70">
                            <span class="text-xs font-extrabold uppercase text-maroon tracking-wider">Step 1: Create Product</span>
                            <h5 class="font-bold text-gray-900 mt-1">Fill Basic Information</h5>
                            <p class="text-xs text-gray-600 mt-1">Navigate to <strong>Products &rarr; Add New Product</strong>. Choose the appropriate category (Kitchen, Home Decor, Dining, etc.) and give the product a descriptive title.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200/70">
                            <span class="text-xs font-extrabold uppercase text-maroon tracking-wider">Step 2: Pricing & Discounts</span>
                            <h5 class="font-bold text-gray-900 mt-1">Sale Prices Trigger Badges</h5>
                            <p class="text-xs text-gray-600 mt-1">Enter regular <strong>Price</strong> (in ₦). If you enter a lower <strong>Sale Price</strong>, an eye-catching red <span class="bg-red-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded">SALE</span> badge automatically appears on storefront cards!</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200/70">
                            <span class="text-xs font-extrabold uppercase text-maroon tracking-wider">Step 3: High-Quality Photos</span>
                            <h5 class="font-bold text-gray-900 mt-1">Live Image Previews</h5>
                            <p class="text-xs text-gray-600 mt-1">Select one or multiple photos from your device. Live previews will display instantly before saving. The first image automatically serves as the primary storefront thumbnail.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200/70">
                            <span class="text-xs font-extrabold uppercase text-maroon tracking-wider">Step 4: Inventory Tracking</span>
                            <h5 class="font-bold text-gray-900 mt-1">Low Stock Alerts</h5>
                            <p class="text-xs text-gray-600 mt-1">Set available quantity in <strong>Stock</strong>. Whenever stock drops to 5 units or below, the Dashboard flags it under the <strong>Low Stock</strong> warning filter.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Promo & WhatsApp -->
                <div id="tab-promo" class="guide-content-panel hidden space-y-4">
                    <div class="flex items-center space-x-2 text-maroon font-bold text-base">
                        <span>📢</span>
                        <h4>1-Click Social Media & WhatsApp Caption Generator</h4>
                    </div>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-xs text-amber-900">
                        <strong>💡 Marketing Power Feature:</strong> You never have to manually type promotional captions for your products! Karakopo creates ready-to-publish social captions formatted with emojis, discount pricing, bank details, and direct buy links.
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3 bg-gray-50 p-3.5 rounded-xl border border-gray-200/70">
                            <span class="w-6 h-6 rounded-full bg-maroon text-white font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                            <div>
                                <h5 class="font-bold text-gray-900 text-xs">Open the Products List</h5>
                                <p class="text-xs text-gray-600">Go to <strong>Products</strong> in the Admin sidebar and locate any item you want to market.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 bg-gray-50 p-3.5 rounded-xl border border-gray-200/70">
                            <span class="w-6 h-6 rounded-full bg-maroon text-white font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                            <div>
                                <h5 class="font-bold text-gray-900 text-xs">Click "📢 Promo & Share"</h5>
                                <p class="text-xs text-gray-600">An interactive modal pops up with 3 tailored caption styles: <em>WhatsApp Status Blast</em>, <em>Flash Discount Offer</em>, and <em>Minimalist Catalog</em>.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 bg-gray-50 p-3.5 rounded-xl border border-gray-200/70">
                            <span class="w-6 h-6 rounded-full bg-maroon text-white font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                            <div>
                                <h5 class="font-bold text-gray-900 text-xs">Copy or Direct WhatsApp</h5>
                                <p class="text-xs text-gray-600">Click <strong>"Copy Caption"</strong> or <strong>"Share via WhatsApp"</strong> to post straight to your WhatsApp Status, Broadcast list, or customer chats.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Orders & OPay -->
                <div id="tab-orders" class="guide-content-panel hidden space-y-4">
                    <div class="flex items-center space-x-2 text-maroon font-bold text-base">
                        <span>💳</span>
                        <h4>Managing Orders & Bank Transfer Verification</h4>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-xs text-blue-900">
                        <strong>Store Bank Details:</strong> All direct bank transfer payments on Karakopo are directed to:
                        <div class="mt-1 font-mono font-bold text-sm text-blue-950">OPay • 8135631609 • Karakopo Retail</div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200/70">
                            <span class="text-xs font-bold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded">1. Pending</span>
                            <p class="text-xs text-gray-600 mt-2">The customer completed checkout and selected Bank Transfer. Check your OPay app to confirm receipt of the exact order total.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200/70">
                            <span class="text-xs font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded">2. Processing</span>
                            <p class="text-xs text-gray-600 mt-2">Payment is verified. Change Payment Status to <strong>Paid</strong> and Order Status to <strong>Processing</strong> while packaging goods.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200/70">
                            <span class="text-xs font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded">3. Delivered</span>
                            <p class="text-xs text-gray-600 mt-2">Dispatch item via dispatch rider or interstate courier. Mark as <strong>Delivered</strong> once the customer receives their package.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: WhatsApp Checkout Flow -->
                <div id="tab-whatsapp" class="guide-content-panel hidden space-y-4">
                    <div class="flex items-center space-x-2 text-maroon font-bold text-base">
                        <span>💬</span>
                        <h4>Customer WhatsApp Checkout & Support Line</h4>
                    </div>
                    <p class="text-xs text-gray-600">Karakopo integrates seamlessly with Nigerian shoppers' favorite channel: <strong>WhatsApp</strong>.</p>
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-xs text-emerald-950 space-y-2">
                        <p><strong>Official Store WhatsApp Line:</strong> <span class="font-bold">+234 812 621 5642</span> (08126215642)</p>
                        <p>When a shopper completes an order on the website, they are provided an instant <strong>"Send Order to WhatsApp"</strong> button that automatically prepares a complete breakdown of items, order number, and delivery address to your phone.</p>
                    </div>
                </div>

                <!-- Tab 5: Developer Support for Mum -->
                <div id="tab-developer" class="guide-content-panel hidden space-y-4">
                    <div class="flex items-center space-x-2 text-brand-maroon font-bold text-base">
                        <span>❤️</span>
                        <h4>Direct Support from Your Son / Developer</h4>
                    </div>
                    <p class="text-xs text-gray-600">
                        Mum, don't worry about any technical stress! I built this platform for you and I am always on standby to help with anything you need:
                    </p>
                    
                    <div class="bg-gradient-to-br from-[#520118] via-[#3B0011] to-gray-900 text-white rounded-2xl p-5 shadow-lg border border-white/10">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <span class="text-[10px] uppercase font-bold tracking-widest text-brand-amber">Always on Call For You</span>
                                <h4 class="text-xl font-black text-white mt-0.5">+234 703 229 3819</h4>
                                <p class="text-xs text-white/80">Call or chat me anytime for uploading products, changing prices, or fixing anything!</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="https://wa.me/2347032293819?text=Hi%20son,%20I%20need%20help%20with%20something%20on%20Karakopo..." target="_blank" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-xl shadow transition-colors">
                                    💬 Chat with Me on WhatsApp
                                </a>
                                <a href="tel:+2347032293819" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-xs font-bold rounded-xl shadow transition-colors">
                                    📞 Call My Line
                                </a>
                                <button type="button" onclick="navigator.clipboard.writeText('+2347032293819'); window.showToast('My phone number (+2347032293819) copied!');" class="inline-flex items-center px-3 py-2 bg-white text-gray-900 hover:bg-gray-100 text-xs font-bold rounded-xl shadow transition-colors">
                                    📋 Copy Number
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 border-t border-gray-200 px-5 py-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-gray-500 flex items-center">
                    <span class="mr-1">📞</span>
                    Your Son / Developer: <strong class="text-gray-900 ml-1">+234 703 229 3819</strong>
                </div>
                <button type="button" onclick="closeOnboardingModal()" class="w-full sm:w-auto px-5 py-2 bg-maroon hover-bg-maroon text-white text-xs sm:text-sm font-bold rounded-xl shadow transition-colors">
                    Got it, Close Guide
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    function openOnboardingModal(tab = 'tab-products') {
        const modal = document.getElementById('onboarding-modal');
        if (modal) {
            modal.classList.remove('hidden');
            switchGuideTab(tab);
        }
    }

    function closeOnboardingModal() {
        const modal = document.getElementById('onboarding-modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function switchGuideTab(tabId) {
        document.querySelectorAll('.guide-content-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
        document.querySelectorAll('.guide-tab-btn').forEach(btn => {
            btn.classList.remove('text-maroon', 'bg-white', 'shadow-sm', 'border', 'border-gray-200');
            btn.classList.add('text-gray-600');
        });

        const activePanel = document.getElementById(tabId);
        if (activePanel) {
            activePanel.classList.remove('hidden');
        }

        const activeBtn = document.getElementById('btn-' + tabId);
        if (activeBtn) {
            activeBtn.classList.remove('text-gray-600');
            activeBtn.classList.add('text-maroon', 'bg-white', 'shadow-sm', 'border', 'border-gray-200');
        }
    }

    // Keyboard Escape to close modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeOnboardingModal();
        }
    });
</script>
