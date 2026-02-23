<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900">Stock Opname</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-900">Stock Opname</p>
                            <p class="text-sm text-yellow-700 mt-1">Input stok aktual hasil perhitungan fisik. Sistem akan otomatis membuat pergerakan untuk selisih.</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('stock.opname.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Barang <span class="text-red-500">*</span></label>
                            <select name="product_id" 
                                    class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->code }} — {{ $p->name }} (Stok Sistem: {{ $p->current_stock }})</option>
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Stok Aktual (Hasil Hitung Fisik) <span class="text-red-500">*</span></label>
                            <input type="number" 
                                   name="actual" 
                                   value="{{ old('actual',0) }}" 
                                   min="0"
                                   class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                                   placeholder="0" />
                            <p class="text-xs text-gray-500 mt-1">Masukkan jumlah stok hasil perhitungan fisik di gudang/toko</p>
                            @error('actual') <p class="text-red-600 text-xs mt-1 flex items-center">
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
                                      placeholder="Contoh: Opname bulanan Februari 2026">{{ old('notes') }}</textarea>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <x-button type="submit" variant="primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Simpan Opname
                            </x-button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
