<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Detail Barang</h2>
            <div class="flex gap-2">
                <x-button variant="secondary" href="{{ route('products.edit', $product) }}" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </x-button>
                <x-button variant="ghost" href="{{ route('products.index') }}" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Foto Produk -->
                <div class="lg:col-span-1">
                    <x-card>
                        @if($product->photo_path)
                            <img class="rounded-lg border border-gray-200 w-full" 
                                 src="{{ asset('storage/'.$product->photo_path) }}" 
                                 alt="Foto {{ $product->name }}">
                        @else
                            <div class="rounded-lg border-2 border-dashed border-gray-300 p-12 text-center">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-gray-500 text-sm">Tidak ada foto</p>
                            </div>
                        @endif
                    </x-card>
                </div>

                <!-- Detail Produk -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Dasar -->
                    <x-card>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-medium text-gray-500 mb-1">Kode Barang</p>
                                <p class="font-mono text-sm font-semibold text-gray-900">{{ $product->code }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 mb-1">Nama Barang</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $product->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 mb-1">Kategori</p>
                                <x-badge color="primary">{{ $product->category->name }}</x-badge>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 mb-1">Satuan</p>
                                <x-badge color="gray">{{ $product->unit->name }} ({{ $product->unit->symbol }})</x-badge>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 mb-1">Status</p>
                                @if($product->is_active)
                                    <x-badge color="accent">✅ Aktif</x-badge>
                                @else
                                    <x-badge color="gray">❌ Nonaktif</x-badge>
                                @endif
                            </div>
                        </div>
                    </x-card>

                    <!-- Harga & Stok -->
                    <x-card>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Harga & Stok</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                <p class="text-xs font-medium text-blue-600 mb-1">Harga Beli</p>
                                <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($product->cost_price,0,',','.') }}</p>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <p class="text-xs font-medium text-green-600 mb-1">Harga Jual</p>
                                <p class="text-2xl font-bold text-green-900">Rp {{ number_format($product->sell_price,0,',','.') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-xs font-medium text-gray-600 mb-1">Stok Saat Ini</p>
                                <div class="flex items-baseline gap-2">
                                    <p class="text-2xl font-bold text-gray-900">{{ $product->current_stock }}</p>
                                    @if($product->current_stock <= 10)
                                        <x-badge color="red">Kritis</x-badge>
                                    @elseif($product->current_stock <= 50)
                                        <x-badge color="yellow">Rendah</x-badge>
                                    @else
                                        <x-badge color="green">Aman</x-badge>
                                    @endif
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-xs font-medium text-gray-600 mb-1">Stok Minimum</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $product->stock_minimum }}</p>
                            </div>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
