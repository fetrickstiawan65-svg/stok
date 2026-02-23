<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Detail Penjualan</h2>
            <div class="flex gap-2">
                <x-button variant="secondary" href="{{ route('sales.print',$sale) }}" target="_blank" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak
                </x-button>
                <x-button variant="ghost" href="{{ route('sales.index') }}" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Header Info -->
            <x-card>
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $sale->invoice_no }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($sale->date)->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="text-right">
                        @if($sale->status === 'PAID')
                            <x-badge color="accent" size="lg">LUNAS</x-badge>
                        @else
                            <x-badge color="gray" size="lg">VOID</x-badge>
                        @endif
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 pt-6 border-t border-gray-200">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Metode Pembayaran</p>
                        @if($sale->payment_method === 'cash')
                            <x-badge color="green">💵 Cash</x-badge>
                        @elseif($sale->payment_method === 'transfer')
                            <x-badge color="blue">🏦 Transfer</x-badge>
                        @else
                            <x-badge color="primary">📱 QRIS</x-badge>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Kasir</p>
                        <p class="text-sm font-medium text-gray-900">{{ $sale->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Waktu Transaksi</p>
                        <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($sale->created_at)->format('H:i:s') }}</p>
                    </div>
                </div>
            </x-card>

            <!-- Items Table -->
            <x-card :noPadding="true">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Item Penjualan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left bg-gray-50 border-b border-gray-200">
                                <th class="py-3 px-6 font-semibold text-gray-700">Barang</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-center w-24">Qty</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-right">Harga</th>
                                <th class="py-3 px-6 font-semibold text-gray-700 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($sale->items as $it)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-6 font-medium text-gray-900">{{ $it->product->name }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <span class="inline-block bg-gray-100 px-3 py-1 rounded-full text-xs font-medium">{{ $it->qty }}</span>
                                    </td>
                                    <td class="py-3 px-6 text-right text-gray-700">Rp {{ number_format($it->price,0,',','.') }}</td>
                                    <td class="py-3 px-6 text-right font-semibold text-gray-900">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <!-- Summary -->
            <x-card>
                <div class="max-w-md ml-auto space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($sale->subtotal,0,',','.') }}</span>
                    </div>
                    @if($sale->discount_total > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Diskon</span>
                            <span class="font-medium text-red-600">- Rp {{ number_format($sale->discount_total,0,',','.') }}</span>
                        </div>
                    @endif
                    @if($sale->tax_amount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Pajak</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($sale->tax_amount,0,',','.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between pt-3 border-t-2 border-gray-300">
                        <span class="text-base font-semibold text-gray-900">Grand Total</span>
                        <span class="text-xl font-bold text-primary-600">Rp {{ number_format($sale->grand_total,0,',','.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm pt-3 border-t border-gray-200">
                        <span class="text-gray-600">Dibayar</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($sale->paid_amount,0,',','.') }}</span>
                    </div>
                    @if($sale->change_amount > 0)
                        <div class="flex justify-between text-sm bg-green-50 -mx-6 px-6 py-3 rounded-lg">
                            <span class="font-medium text-green-700">Kembalian</span>
                            <span class="font-bold text-green-700">Rp {{ number_format($sale->change_amount,0,',','.') }}</span>
                        </div>
                    @endif
                </div>

                @if(in_array(auth()->user()->role, ['owner','admin']) && $sale->status !== 'VOID')
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <form method="POST" action="{{ route('sales.void',$sale) }}" onsubmit="return confirm('VOID penjualan ini? Stok akan dikembalikan!')">
                            @csrf
                            <x-button type="submit" variant="danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                VOID Penjualan
                            </x-button>
                        </form>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</x-app-layout>
