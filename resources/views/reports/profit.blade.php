<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Profit Sederhana</h2>
            <x-button variant="ghost" href="{{ route('reports.dashboard') }}" size="sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Laporan
            </x-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Filter -->
            <x-card>
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
            </x-card>

            <!-- Info & Result -->
            <x-card>
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Metode Perhitungan</p>
                            <p class="text-sm text-blue-700 mt-1">Profit dihitung dari (Harga Jual - Harga Beli) × Qty berdasarkan snapshot saat transaksi (bukan FIFO/average cost).</p>
                        </div>
                    </div>
                </div>

                <div class="text-center py-8">
                    <p class="text-sm font-medium text-gray-500 uppercase mb-2">Estimasi Profit</p>
                    <div class="inline-flex items-center justify-center p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                        <div>
                            <p class="text-5xl font-bold text-green-600">Rp {{ number_format($profit,0,',','.') }}</p>
                            <p class="text-sm text-green-700 mt-2">Periode {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
