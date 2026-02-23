<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Riwayat Penjualan</h2>
            <x-button variant="secondary" href="{{ route('pos.index') }}" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke POS
            </x-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card :noPadding="true">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                            <input type="date" name="from" value="{{ $from }}" 
                                   class="w-full px-3 py-2 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        <div class="md:col-span-1">
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
                            <x-button variant="ghost" href="{{ route('sales.index') }}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">No. Invoice</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-right">Grand Total</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Metode Bayar</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-center">Status</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Kasir</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($items as $s)
                                <tr class="hover:bg-gray-50 transition-colors {{ $loop->iteration % 2 == 0 ? 'bg-gray-25' : 'bg-white' }}">
                                    <td class="py-3 px-4">
                                        <span class="text-gray-700">{{ \Carbon\Carbon::parse($s->date)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a class="font-mono text-xs text-primary-600 hover:text-primary-800" href="{{ route('sales.show',$s) }}">
                                            {{ $s->invoice_no }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($s->grand_total,0,',','.') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($s->payment_method === 'cash')
                                            <x-badge color="green">💵 Cash</x-badge>
                                        @elseif($s->payment_method === 'transfer')
                                            <x-badge color="blue">🏦 Transfer</x-badge>
                                        @else
                                            <x-badge color="primary">📱 QRIS</x-badge>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($s->status === 'PAID')
                                            <x-badge color="accent">LUNAS</x-badge>
                                        @else
                                            <x-badge color="gray">VOID</x-badge>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-gray-700 text-sm">{{ $s->user->name }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ route('sales.show',$s) }}" 
                                           class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-700 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada data penjualan</p>
                                        <p class="text-gray-400 text-sm mt-1">Silakan ubah filter atau lakukan transaksi baru di POS</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($items->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $items->links() }}
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
