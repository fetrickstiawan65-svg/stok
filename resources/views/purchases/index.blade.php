<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Data Pembelian</h2>
            <x-button variant="primary" href="{{ route('purchases.create') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pembelian
            </x-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card :noPadding="true">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-4 font-semibold text-gray-700">No. Invoice</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Supplier</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-right">Total</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-center">Status</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($items as $p)
                                <tr class="hover:bg-gray-50 transition-colors {{ $loop->iteration % 2 == 0 ? 'bg-gray-25' : 'bg-white' }}">
                                    <td class="py-3 px-4">
                                        <span class="font-mono text-xs text-gray-600">{{ $p->invoice_no }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-gray-700">{{ \Carbon\Carbon::parse($p->date)->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="font-medium text-gray-900">{{ $p->supplier->name }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($p->grand_total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($p->status === 'RECEIVED')
                                            <x-badge color="accent">DITERIMA</x-badge>
                                        @else
                                            <x-badge color="gray">VOID</x-badge>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('purchases.show', $p) }}" 
                                               class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-700 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors"
                                               title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada data pembelian</p>
                                        <p class="text-gray-400 text-sm mt-1">Silakan tambah pembelian baru dari supplier</p>
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
