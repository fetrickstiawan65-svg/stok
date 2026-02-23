<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Welcome Section --}}
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-700">
                    Selamat datang, <span class="text-primary-600 font-semibold">{{ auth()->user()->name }}</span>!
                </h3>
                <p class="text-sm text-gray-500 mt-1">Role: <x-badge color="primary" size="sm">{{ strtoupper($role) }}</x-badge></p>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                {{-- Today Revenue --}}
                <x-card :noPadding="true" class="border-l-4 border-primary-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-primary-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </x-card>

                {{-- Month Revenue --}}
                <x-card :noPadding="true" class="border-l-4 border-accent-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pendapatan Bulan Ini</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    Rp {{ number_format($monthRevenue, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-accent-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </x-card>

                {{-- Today Sales Count --}}
                <x-card :noPadding="true" class="border-l-4 border-blue-600">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Transaksi Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $todaySalesCount }}</p>
                                <p class="text-xs text-gray-500 mt-1">transaksi</p>
                            </div>
                            <div class="bg-blue-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </x-card>

                {{-- Low Stock Alert --}}
                <x-card :noPadding="true" class="border-l-4 {{ $lowStockCount > 0 ? 'border-red-600' : 'border-gray-300' }}">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Stok Menipis</p>
                                <p class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-red-600' : 'text-gray-900' }} mt-2">
                                    {{ $lowStockCount }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">produk (≤10)</p>
                            </div>
                            <div class="bg-{{ $lowStockCount > 0 ? 'red' : 'gray' }}-100 rounded-full p-3">
                                <svg class="w-6 h-6 text-{{ $lowStockCount > 0 ? 'red' : 'gray' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>

            {{-- Quick Actions --}}
            <x-card title="Aksi Cepat" class="mb-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <x-button variant="primary" href="{{ route('pos.index') }}" class="justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Kasir (POS)
                    </x-button>

                    @if(in_array($role, ['owner', 'admin']))
                        <x-button variant="secondary" href="{{ route('products.index') }}" class="justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Kelola Barang
                        </x-button>

                        <x-button variant="secondary" href="{{ route('reports.dashboard') }}" class="justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Lihat Laporan
                        </x-button>

                        <x-button variant="secondary" href="{{ route('sales.index') }}" class="justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Riwayat Penjualan
                        </x-button>
                    @endif
                </div>
            </x-card>

            {{-- Recent Transactions --}}
            <x-card title="Transaksi Terbaru">
                @if($recentSales->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left border-b border-gray-200 bg-gray-50">
                                    <th class="py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Invoice</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Items</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700 text-right">Total</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Metode</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recentSales as $sale)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-4 text-gray-700">{{ $sale->date }}</td>
                                        <td class="py-3 px-4">
                                            <span class="font-medium text-primary-600">{{ $sale->invoice_number }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-600">{{ $sale->items->count() }} item(s)</td>
                                        <td class="py-3 px-4 text-right font-semibold text-gray-900">
                                            Rp {{ number_format($sale->grand_total, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4">
                                            <x-badge :color="$sale->payment_method === 'cash' ? 'green' : 'blue'" size="sm">
                                                {{ strtoupper($sale->payment_method) }}
                                            </x-badge>
                                        </td>
                                        <td class="py-3 px-4">
                                            @if(in_array($role, ['owner', 'admin']))
                                                <a href="{{ route('sales.show', $sale) }}" class="text-primary-600 hover:text-primary-800 font-medium">
                                                    Lihat
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500">Belum ada transaksi</p>
                    </div>
                @endif
            </x-card>

        </div>
    </div>
</x-app-layout>
