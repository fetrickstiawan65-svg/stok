<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Laporan Penjualan Harian</h2>
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
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                        <div class="flex items-end">
                            <x-button variant="ghost" href="{{ route('reports.sales_summary') }}" class="w-full">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </x-button>
                        </div>
                        <div class="flex items-end">
                            <x-button variant="secondary" href="{{ route('reports.export_sales_csv',['from'=>$from,'to'=>$to]) }}" class="w-full">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Export
                            </x-button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-6 font-semibold text-gray-700">Tanggal</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-right">Jumlah Transaksi</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-right">Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($rows as $r)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-6">
                                        <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($r->day)->format('d F Y') }}</span>
                                    </td>
                                    <td class="py-3 px-6 text-right">
                                        <x-badge color="primary">{{ $r->trx_count }} transaksi</x-badge>
                                    </td>
                                    <td class="py-3 px-6 text-right font-semibold text-green-600">
                                        Rp {{ number_format($r->total,0,',','.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
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
