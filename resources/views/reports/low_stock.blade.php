<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Stok Menipis</h2>
            <div class="flex gap-2">
                <x-button variant="secondary" href="{{ route('reports.export_low_stock_csv') }}" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export CSV
                </x-button>
                <x-button variant="ghost" href="{{ route('reports.dashboard') }}" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Laporan
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card :noPadding="true">
                <div class="px-6 py-4 bg-red-50 border-b border-red-200">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-red-900">Perhatian: Stok Rendah</p>
                            <p class="text-sm text-red-700 mt-1">Daftar barang dengan stok ≤ stok minimum. Pertimbangkan untuk re-stock segera.</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-6 font-semibold text-gray-700">Kode</th>
                                <th class="py-3 px-6 font-semibold text-gray-700">Nama Barang</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-right">Stok Saat Ini</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-right">Stok Minimum</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($items as $p)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-6">
                                        <span class="font-mono text-xs text-gray-600">{{ $p->code }}</span>
                                    </td>
                                    <td class="py-3 px-6 font-medium text-gray-900">{{ $p->name }}</td>
                                    <td class="py-3 px-6 text-right">
                                        <span class="font-bold text-red-600">{{ $p->current_stock }}</span>
                                    </td>
                                    <td class="py-3 px-6 text-right text-gray-700">{{ $p->stock_minimum }}</td>
                                    <td class="py-3 px-6 text-center">
                                        @if($p->current_stock <= 10)
                                            <x-badge color="red">🔴 Kritis</x-badge>
                                        @elseif($p->current_stock <= 50)
                                            <x-badge color="yellow">🟡 Rendah</x-badge>
                                        @else
                                            <x-badge color="gray">Low</x-badge>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada stok menipis</p>
                                        <p class="text-gray-400 text-sm mt-1">Semua barang memiliki stok yang cukup</p>
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
