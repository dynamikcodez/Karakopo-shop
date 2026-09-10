@extends('admin.layouts.app')

@section('title', 'Product Catalog')

@section('content')
<div class="space-y-6">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h3 class="text-base font-bold text-gray-900">Manage Products</h3>
            <p class="text-xs text-gray-500">Create, update products, and generate marketing captions & links</p>
        </div>
        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <a href="{{ route('admin.products.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-maroon text-white text-xs sm:text-sm font-bold rounded-xl hover-bg-maroon shadow transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New Product
            </a>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 font-semibold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Product</th>
                        <th class="py-3.5 px-4">Category</th>
                        <th class="py-3.5 px-4">Price / Stock</th>
                        <th class="py-3.5 px-4">Visibility</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Marketing & Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        @php
                            $publicUrl = route('product.show', $product->slug);
                            $effectivePrice = $product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price;
                            $wasPriceStr = $product->sale_price && $product->sale_price < $product->price ? " (was ₦" . number_format($product->price) . ")" : "";
                            $promoCaption = "✨ *" . $product->name . "* ✨\n"
                                          . ($product->short_description ? $product->short_description . "\n\n" : "")
                                          . "💰 *Price:* ₦" . number_format($effectivePrice) . $wasPriceStr . "\n"
                                          . "📦 Available Stock: " . $product->stock . " units\n"
                                          . "🚚 Doorstep delivery across Nigeria!\n\n"
                                          . "🛒 *Order easily here:* " . $publicUrl . "\n\n"
                                          . "*Karakopo* — Spend less. Buy more. 🛍️";
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Product Image & Name -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex-shrink-0 overflow-hidden border border-gray-200">
                                        @if($product->primaryImage)
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-gray-900 text-sm truncate max-w-xs sm:max-w-sm">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">SKU: {{ $product->sku }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="py-4 px-4 whitespace-nowrap text-xs sm:text-sm text-gray-600">
                                <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-md text-xs font-semibold">
                                    {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                </span>
                            </td>

                            <!-- Price & Stock -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="text-sm font-black text-gray-900">
                                    ₦{{ number_format($product->price, 2) }}
                                </div>
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <div class="text-xs text-red-600 font-bold">
                                        Sale: ₦{{ number_format($product->sale_price, 2) }}
                                    </div>
                                @endif
                                <div class="text-xs mt-1 font-semibold {{ $product->stock <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                    Stock: {{ $product->stock }}
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($product->is_published)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        ● Live
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                        Draft
                                    </span>
                                @endif
                                @if($product->is_featured)
                                    <span class="block mt-1 text-[10px] font-bold text-amber-600 uppercase">★ Featured</span>
                                @endif
                            </td>

                            <!-- Actions & Promotional Tools -->
                            <td class="py-4 px-4 sm:px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Promo Share Button -->
                                    <button type="button" 
                                            onclick='openPromoModal(@json($product->name), @json($promoCaption), @json($publicUrl), @json($effectivePrice))' 
                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-bold bg-maroon text-white hover-bg-maroon transition-colors shadow-sm" 
                                            title="Get promotional caption & share links">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                        Promo & Share
                                    </button>

                                    <!-- Public Link -->
                                    <a href="{{ $publicUrl }}" target="_blank" class="p-1.5 text-gray-500 hover:text-maroon hover:bg-gray-100 rounded-lg transition-colors" title="View in store">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.products.edit', $product) }}" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Edit product">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product? All photos and data will be removed.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Delete product">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                No products found in your catalog. Click "Add New Product" to create one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Promotional Marketing Modal -->
<div id="promo-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-100 animate-in fade-in zoom-in duration-200">
        <!-- Modal Header -->
        <div class="bg-maroon text-white px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-lg">📢</span>
                <h3 class="font-bold text-base" id="modal-product-title">Promotional Toolkit</h3>
            </div>
            <button type="button" onclick="closePromoModal()" class="text-white/70 hover:text-white text-2xl font-bold leading-none">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                    Pre-generated Social Caption (WhatsApp / Telegram / Instagram):
                </label>
                <textarea id="modal-promo-caption" rows="7" readonly class="w-full text-xs font-mono bg-gray-50 border border-gray-200 rounded-xl p-3 text-gray-800 focus:outline-none select-all"></textarea>
            </div>

            <!-- Action Buttons Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2">
                <button type="button" onclick="copyModalPromo()" class="w-full py-2.5 px-4 bg-maroon text-white text-xs font-bold rounded-xl hover-bg-maroon transition-colors shadow flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                    <span>Copy Full Caption</span>
                </button>

                <a id="modal-whatsapp-link" href="#" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 px-4 bg-[#25D366] hover:bg-[#20ba59] text-white text-xs font-bold rounded-xl transition-colors shadow flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.18-2.587-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.12-.497-1.782-.71-2.909-2.529-2.998-2.646-.088-.118-.72-1.002-.72-1.911 0-.91.468-1.357.636-1.542.167-.184.364-.23.486-.23.121 0 .243.001.35.006.113.006.264-.043.413.315.155.372.53 1.29.576 1.383.045.093.076.202.015.323-.061.121-.091.196-.182.302-.091.106-.192.237-.274.318-.091.091-.186.19-.08.372.106.182.472.78 1.012 1.261.696.62 1.282.812 1.464.903.182.091.288.076.394-.045.106-.121.455-.53.576-.712.121-.182.243-.152.409-.091.167.061 1.059.5 1.241.591.182.091.303.136.348.212.045.076.045.439-.099.844z"/></svg>
                    <span>Post to WhatsApp</span>
                </a>

                <a id="modal-telegram-link" href="#" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 px-4 bg-[#0088cc] hover:bg-[#0077b5] text-white text-xs font-bold rounded-xl transition-colors shadow flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.52 2.77-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                    <span>Send to Telegram</span>
                </a>

                <button type="button" onclick="copyModalLinkOnly()" class="w-full py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold rounded-xl transition-colors shadow-sm flex items-center justify-center space-x-1.5">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    <span>Copy Link Only</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let activeProductUrl = '';
    let activePromoCaption = '';

    function openPromoModal(name, caption, url, price) {
        activeProductUrl = url;
        activePromoCaption = caption;

        document.getElementById('modal-product-title').innerText = name;
        document.getElementById('modal-promo-caption').value = caption;
        document.getElementById('modal-whatsapp-link').href = 'https://wa.me/?text=' + encodeURIComponent(caption);
        document.getElementById('modal-telegram-link').href = 'https://t.me/share/url?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(caption);

        document.getElementById('promo-modal').classList.remove('hidden');
    }

    function closePromoModal() {
        document.getElementById('promo-modal').classList.add('hidden');
    }

    // Close on backdrop click
    document.getElementById('promo-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePromoModal();
        }
    });

    function copyModalPromo() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(activePromoCaption).then(() => {
                window.showToast('Promotional caption copied!');
            });
        }
    }

    function copyModalLinkOnly() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(activeProductUrl).then(() => {
                window.showToast('Product URL copied!');
            });
        }
    }
</script>
@endpush
@endsection
