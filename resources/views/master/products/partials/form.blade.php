@php
    $p = $product;
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Kode Barang <span class="text-red-500">*</span>
            </label>
            <input name="code" 
                   value="{{ old('code', $p->code ?? '') }}" 
                   class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                   placeholder="Contoh: BRG-001" />
            @error('code') <p class="text-red-600 text-xs mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Barang <span class="text-red-500">*</span>
            </label>
            <input name="name" 
                   value="{{ old('name', $p->name ?? '') }}" 
                   class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                   placeholder="Contoh: Semen Gresik 50kg" />
            @error('name') <p class="text-red-600 text-xs mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Kategori <span class="text-red-500">*</span>
            </label>
            <select name="category_id" 
                    class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $p->category_id ?? '')==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-xs mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Satuan <span class="text-red-500">*</span>
            </label>
            <select name="unit_id" 
                    class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <option value="">-- Pilih Satuan --</option>
                @foreach($units as $u)
                    <option value="{{ $u->id }}" @selected(old('unit_id', $p->unit_id ?? '')==$u->id)>{{ $u->name }} ({{ $u->symbol }})</option>
                @endforeach
            </select>
            @error('unit_id') <p class="text-red-600 text-xs mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Harga Beli (Rp) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                <input type="number" 
                       name="cost_price" 
                       value="{{ old('cost_price', $p->cost_price ?? 0) }}" 
                       class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                       placeholder="0" />
            </div>
            @error('cost_price') <p class="text-red-600 text-xs mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Harga Jual (Rp) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                <input type="number" 
                       name="sell_price" 
                       value="{{ old('sell_price', $p->sell_price ?? 0) }}" 
                       class="w-full pl-10 pr-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                       placeholder="0" />
            </div>
            @error('sell_price') <p class="text-red-600 text-xs mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Stok Minimum
            </label>
            <input type="number" 
                   name="stock_minimum" 
                   value="{{ old('stock_minimum', $p->stock_minimum ?? 10) }}" 
                   class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                   placeholder="10" />
            <p class="text-xs text-gray-500 mt-1">💡 Stok di bawah nilai ini akan ditandai sebagai stok menipis</p>
            @error('stock_minimum') <p class="text-red-600 text-xs mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Status Barang
            </label>
            <select name="is_active" 
                    class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <option value="1" @selected(old('is_active', $p->is_active ?? 1)==1)>✅ Aktif (Dijual)</option>
                <option value="0" @selected(old('is_active', $p->is_active ?? 1)==0)>❌ Nonaktif (Tidak Dijual)</option>
            </select>
            @error('is_active') <p class="text-red-600 text-xs mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p> @enderror
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Foto Barang (Opsional)
        </label>
        <input type="file" 
               name="photo" 
               accept="image/*"
               class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" />
        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
        @error('photo') <p class="text-red-600 text-xs mt-1 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
        </p> @enderror
        @if($p && $p->photo_path)
            <div class="mt-3 flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-700">Foto saat ini:</p>
                    <p class="text-xs text-gray-500">{{ $p->photo_path }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
