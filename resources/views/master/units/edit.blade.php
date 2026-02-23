<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Edit Satuan: {{ $unit->name }}</h2>
            <x-button variant="ghost" href="{{ route('units.index') }}" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </x-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('units.update',$unit) }}">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Satuan <span class="text-red-500">*</span>
                            </label>
                            <input name="name" 
                                   value="{{ old('name', $unit->name) }}" 
                                   class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                                   placeholder="Contoh: Kilogram, Karung, Pieces" />
                            @error('name') <p class="text-red-600 text-xs mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Simbol <span class="text-red-500">*</span>
                            </label>
                            <input name="symbol" 
                                   value="{{ old('symbol', $unit->symbol) }}" 
                                   class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                                   placeholder="Contoh: kg, sak, pcs" />
                            <p class="text-xs text-gray-500 mt-1">Simbol pendek untuk ditampilkan di laporan dan struk</p>
                            @error('symbol') <p class="text-red-600 text-xs mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p> @enderror
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                            <x-button type="submit" variant="primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update
                            </x-button>
                            <x-button type="button" variant="secondary" onclick="window.location='{{ route('units.index') }}'">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </x-button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
