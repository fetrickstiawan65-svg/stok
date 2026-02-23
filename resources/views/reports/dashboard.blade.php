<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900">Laporan & Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <x-card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-xs font-medium text-gray-500 uppercase">Penjualan Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($todaySales,0,',','.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $todayCount }} transaksi</p>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-xs font-medium text-gray-500 uppercase">Stok Menipis</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $lowStockCount }}</p>
                            <p class="text-xs text-gray-500 mt-1">item perlu restock</p>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-xs font-medium text-gray-500 uppercase">Status</p>
                            <p class="text-lg font-semibold text-gray-900">Sistem Normal</p>
                            <p class="text-xs text-gray-500 mt-1">Laporan siap diakses</p>
                        </div>
                    </div>
                </x-card>
            </div>

            <!-- Reports Menu -->
            <x-card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Laporan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('reports.sales_summary') }}" 
                       class="flex items-center p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors group">
                        <div class="flex-shrink-0 bg-blue-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 group-hover:text-blue-700">Penjualan Harian</p>
                            <p class="text-sm text-gray-600">Rekapitulasi penjualan per hari</p>
                        </div>
                    </a>

                    <a href="{{ route('reports.best_sellers') }}" 
                       class="flex items-center p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors group">
                        <div class="flex-shrink-0 bg-green-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 group-hover:text-green-700">Barang Terlaris</p>
                            <p class="text-sm text-gray-600">Produk dengan penjualan tertinggi</p>
                        </div>
                    </a>

                    <a href="{{ route('reports.profit') }}" 
                       class="flex items-center p-4 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors group">
                        <div class="flex-shrink-0 bg-purple-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 group-hover:text-purple-700">Profit Sederhana</p>
                            <p class="text-sm text-gray-600">Estimasi keuntungan penjualan</p>
                        </div>
                    </a>

                    <a href="{{ route('reports.low_stock') }}" 
                       class="flex items-center p-4 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors group">
                        <div class="flex-shrink-0 bg-red-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-900 group-hover:text-red-700">Stok Menipis</p>
                            <p class="text-sm text-gray-600">Daftar barang dengan stok rendah</p>
                        </div>
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
