<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Barang Terlaris</h2>
            <x-button variant="ghost" href="{{ route('reports.dashboard') }}" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Laporan
            </x-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card :noPadding="true">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <div class="flex items-end">
                            <x-button type="submit" variant="secondary" class="w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-6 font-semibold text-gray-700 w-12">#</th>
                                <th class="py-3 px-6 font-semibold text-gray-700">Nama Barang</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-right">Qty Terjual</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-right">Omzet</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($rows as $r)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-6 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                            @if($loop->iteration == 1) bg-yellow-100 text-yellow-700 font-bold
                                            @elseif($loop->iteration == 2) bg-gray-200 text-gray-700 font-bold
                                            @elseif($loop->iteration == 3) bg-orange-100 text-orange-700 font-bold
                                            @else bg-gray-100 text-gray-600 @endif">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 font-medium text-gray-900">{{ $r->product->name ?? '-' }}</td>
                                    <td class="py-3 px-6 text-right">
                                        <span class="font-semibold text-gray-900">{{ number_format($r->qty_total, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3 px-6 text-right font-semibold text-green-600">
                                        Rp {{ number_format($r->revenue_total,0,',','.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada data penjualan</p>
                                        <p class="text-gray-400 text-sm mt-1">Ubah filter atau lakukan transaksi terlebih dahulu</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
