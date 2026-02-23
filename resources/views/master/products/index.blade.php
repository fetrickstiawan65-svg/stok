<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-2xl text-gray-900">Data Barang</h2>
            <x-button variant="primary" href="{{ route('products.create') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Barang
            </x-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card :noPadding="true">
                {{-- Filter Section --}}
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <form class="grid grid-cols-1 md:grid-cols-4 gap-4" method="GET">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari Barang
                            </label>
                            <input name="q" value="{{ $q }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                                   placeholder="Ketik kode atau nama barang..." />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @selected((string)$categoryId===(string)$c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <x-button type="submit" variant="secondary" class="flex-1">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </x-button>
                            <x-button variant="ghost" href="{{ route('products.index') }}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </x-button>
                        </div>
                    </form>
                </div>

                {{-- Table Section --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-4 font-semibold text-gray-700">Kode</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Nama Barang</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Kategori</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Satuan</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-right">Harga Jual</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-right">Stok</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($items as $p)
                                <tr class="hover:bg-gray-50 transition-colors {{ $loop->iteration % 2 == 0 ? 'bg-gray-25' : 'bg-white' }}">
                                    <td class="py-3 px-4">
                                        <span class="font-mono text-xs text-gray-600">{{ $p->code }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <a class="font-medium text-primary-600 hover:text-primary-800" href="{{ route('products.show',$p) }}">
                                                {{ $p->name }}
                                            </a>
                                            @if($p->is_active)
                                                <x-badge color="accent" size="sm">Aktif</x-badge>
                                            @else
                                                <x-badge color="gray" size="sm">Nonaktif</x-badge>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">{{ $p->category->name }}</td>
                                    <td class="py-3 px-4 text-gray-700">{{ $p->unit->symbol }}</td>
                                    <td class="py-3 px-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($p->sell_price,0,',','.') }}
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        @if($p->current_stock <= 10)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $p->current_stock }}
                                            </span>
                                        @elseif($p->current_stock <= 50)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                {{ $p->current_stock }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                {{ $p->current_stock }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('products.show',$p) }}" 
                                               class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-700 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors"
                                               title="Lihat Detail">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Lihat
                                            </a>
                                            <a href="{{ route('products.edit',$p) }}" 
                                               class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-primary-700 hover:text-primary-900 hover:bg-primary-50 rounded-lg transition-colors"
                                               title="Edit">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('products.destroy',$p) }}" 
                                                  onsubmit="return confirm('Hapus barang {{ $p->name }}? Data akan di-soft delete.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-red-700 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Hapus">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada data barang</p>
                                        <p class="text-gray-400 text-sm mt-1">Silakan tambah barang baru atau ubah filter pencarian</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($items->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $items->links() }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
