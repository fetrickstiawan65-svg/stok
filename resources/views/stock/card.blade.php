<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Kartu Stok: {{ $product->name }}</h2>
            <x-button variant="secondary" href="{{ route('products.show',$product) }}" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Detail Barang
            </x-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Product Info & Filter -->
            <x-card>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $product->code }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Stok Saat Ini: <span class="font-bold text-xl text-primary-600">{{ $product->current_stock }}</span></p>
                    </div>
                </div>

                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 pt-6 border-t border-gray-200">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" name="from" value="{{ $from }}" 
                               class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" name="to" value="{{ $to }}" 
                               class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div class="md:col-span-2 flex items-end gap-2">
                        <x-button type="submit" variant="secondary" class="flex-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </x-button>
                        <x-button variant="ghost" href="{{ route('stock.card',$product) }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </x-button>
                    </div>
                </form>
            </x-card>

            <!-- Movement History -->
            <x-card :noPadding="true">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Riwayat Pergerakan Stok</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-4 font-semibold text-gray-700">Waktu</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-center">Tipe</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Referensi</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-right">Masuk</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-right">Keluar</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-right">Saldo</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Oleh</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($movements as $m)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-xs text-gray-600">
                                        {{ \Carbon\Carbon::parse($m->created_at)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($m->type === 'IN')
                                            <x-badge color="green">▲ IN</x-badge>
                                        @else
                                            <x-badge color="red">▼ OUT</x-badge>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-xs font-mono text-gray-600">{{ $m->ref_type }} #{{ $m->ref_id }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        @if($m->qty_in > 0)
                                            <span class="font-medium text-green-600">+{{ $m->qty_in }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        @if($m->qty_out > 0)
                                            <span class="font-medium text-red-600">-{{ $m->qty_out }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="font-bold text-gray-900">{{ $m->balance_after }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-xs text-gray-600">{{ $m->user->name }}</td>
                                    <td class="py-3 px-4 text-xs text-gray-500">{{ $m->notes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada pergerakan stok</p>
                                        <p class="text-gray-400 text-sm mt-1">Pergerakan stok akan muncul di sini</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($movements->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $movements->links() }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
