<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900">Stok Masuk Manual</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('stock.in.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Barang <span class="text-red-500">*</span></label>
                            <select name="product_id" 
                                    class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->code }} — {{ $p->name }} (Stok: {{ $p->current_stock }})</option>
                                @endforeach
                            </select>
                            @error('product_id') <p class="text-red-600 text-xs mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Qty Masuk <span class="text-red-500">*</span></label>
                            <input type="number" 
                                   name="qty" 
                                   value="{{ old('qty',1) }}" 
                                   min="1"
                                   class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                                   placeholder="1" />
                            <p class="text-xs text-gray-500 mt-1">Jumlah barang yang akan ditambahkan ke stok</p>
                            @error('qty') <p class="text-red-600 text-xs mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" 
                                      rows="2"
                                      class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                                      placeholder="Contoh: Koreksi stok manual">{{ old('notes') }}</textarea>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <x-button type="submit" variant="success">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Stok
                            </x-button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
