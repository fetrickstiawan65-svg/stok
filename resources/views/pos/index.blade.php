<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">
                <svg class="w-7 h-7 inline-block mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Point of Sale (POS)
            </h2>
            @if(in_array(auth()->user()->role, ['owner', 'admin']))
                <x-button variant="secondary" href="{{ route('sales.index') }}" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Riwayat Penjualan
                </x-button>
            @endif
        </div>
    </x-slot>

    <div class="py-8" x-data="posApp()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT: Product Search --}}
            <div class="lg:col-span-2">
                <x-card title="Cari Barang" :noPadding="true">
                    <div class="p-6 space-y-4">
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input class="w-full pl-10 pr-4 py-2.5 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500" 
                                       placeholder="Ketik nama atau kode barang..." 
                                       x-model="query" 
                                       @input.debounce.300ms="search()" />
                            </div>
                            <x-button variant="primary" @click="search()">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari
                            </x-button>
                        </div>
                        <p class="text-xs text-gray-500">💡 Klik tombol "Tambah" untuk memasukkan barang ke keranjang</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left bg-gray-50 border-y border-gray-200">
                                    <th class="py-3 px-4 font-semibold text-gray-700">Kode</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700">Nama</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700 text-right">Harga</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700 text-right">Stok</th>
                                    <th class="py-3 px-4 font-semibold text-gray-700 text-center w-24">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="p in products" :key="p.id">
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-4">
                                            <span class="font-mono text-xs text-gray-600" x-text="p.code"></span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="font-medium text-gray-900" x-text="p.name"></span>
                                        </td>
                                        <td class="py-3 px-4 text-right font-semibold text-gray-900" x-text="format(p.sell_price)"></td>
                                        <td class="py-3 px-4 text-right">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                                  :class="p.current_stock <= 10 ? 'bg-red-100 text-red-800' : p.current_stock <= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'"
                                                  x-text="p.current_stock"></span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <template x-if="p.current_stock > 0">
                                                <button type="button" 
                                                        class="inline-flex items-center px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-xs font-medium rounded-lg shadow-sm transition-all hover:scale-105"
                                                        @click="addToCart(p)">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                    Tambah
                                                </button>
                                            </template>
                                            <template x-if="p.current_stock <= 0">
                                                <span class="inline-flex items-center px-3 py-1.5 bg-gray-300 text-gray-500 text-xs font-medium rounded-lg cursor-not-allowed">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                    </svg>
                                                    Habis
                                                </span>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="products.length===0">
                                    <td colspan="5" class="py-8 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm">Tidak ada hasil pencarian</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>

            {{-- RIGHT: Cart --}}
            <div class="lg:col-span-1">
                <x-card :noPadding="true" class="sticky top-6">
                    <div class="p-4 bg-primary-600 text-white">
                        <h3 class="font-bold text-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                            Keranjang Belanja
                        </h3>
                        <p class="text-primary-100 text-xs mt-1" x-text="`${cart.length} item(s) dalam keranjang`"></p>
                    </div>

                    <div class="p-4 space-y-2 max-h-96 overflow-y-auto">
                        <template x-for="(c, idx) in cart" :key="c.product_id">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900" x-text="c.name"></p>
                                        <p class="text-xs text-gray-600" x-text="'@ ' + format(c.price)"></p>
                                    </div>
                                    <button type="button" 
                                            class="text-red-600 hover:text-red-800 hover:bg-red-50 rounded p-1 transition-colors" 
                                            @click="remove(idx)"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2">
                                        <label class="text-xs text-gray-600 font-medium">Qty:</label>
                                        <input type="number" min="1" 
                                               :max="c.stock"
                                               class="w-16 px-2 py-1 text-sm border-gray-300 rounded focus:border-primary-500 focus:ring-primary-500"
                                               x-model.number="c.qty" 
                                               @change="capQty(idx)" />
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-600">Subtotal:</p>
                                        <p class="text-sm font-bold text-primary-600" x-text="format(c.qty * c.price)"></p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="cart.length === 0" class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Keranjang masih kosong</p>
                            <p class="text-gray-400 text-xs mt-1">Mulai tambahkan barang</p>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-50 border-t border-gray-200 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-semibold text-gray-900" x-text="format(subtotal())"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Diskon Total (Rp)</label>
                            <input type="number" min="0" 
                                   class="w-full px-3 py-2 text-sm border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500"
                                   x-model.number="discount" 
                                   @input="recalc()"/>
                        </div>

                        <div class="flex justify-between text-lg font-bold border-t border-gray-300 pt-3">
                            <span class="text-gray-900">Grand Total:</span>
                            <span class="text-primary-600" x-text="format(grandTotal())"></span>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Metode Bayar</label>
                            <select class="w-full px-3 py-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 text-sm"
                                    x-model="payment_method">
                                <option value="cash">💵 Cash</option>
                                <option value="transfer">🏦 Transfer Bank</option>
                                <option value="qris">📱 QRIS</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Uang Dibayar (Rp)</label>
                            <input type="text" inputmode="numeric"
                                   class="w-full px-3 py-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 text-sm"
                                   :value="formatNumber(paid_amount)"
                                   @input="paid_amount = parseNumber($event.target.value)"
                                   @blur="$event.target.value = formatNumber(paid_amount)"/>
                        </div>

                        <div class="flex justify-between text-sm bg-accent-50 border border-accent-200 rounded-lg p-3">
                            <span class="text-accent-800 font-medium">Kembalian:</span>
                            <span class="text-accent-900 font-bold" x-text="format(changeAmount())"></span>
                        </div>

                        <form method="POST" action="{{ route('sales.checkout') }}" @submit.prevent="submitCheckout($event)">
                            @csrf
                            <input type="hidden" name="date" :value="today" />
                            <input type="hidden" name="discount_total" :value="discount" />
                            <input type="hidden" name="payment_method" :value="payment_method" />
                            <input type="hidden" name="paid_amount" :value="paid_amount" />

                            <template x-for="(c, idx) in cart" :key="c.product_id">
                                <div>
                                    <input type="hidden" :name="`items[${idx}][product_id]`" :value="c.product_id" />
                                    <input type="hidden" :name="`items[${idx}][qty]`" :value="c.qty" />
                                </div>
                            </template>


                            <div x-show="checkoutError" x-transition class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-red-800 font-medium" x-text="checkoutError"></span>
                                    <button type="button" @click="checkoutError=''" class="ml-auto text-red-400 hover:text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <x-button type="submit" 
                                      variant="success" 
                                      size="lg"
                                      class="w-full justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Checkout & Simpan
                            </x-button>

                            <p class="text-xs text-gray-500 mt-2 text-center">Setelah checkout, Anda akan dialihkan ke detail transaksi untuk cetak nota</p>
                        </form>
                    </div>
                </x-card>
            </div>
        </div>
    </div>

    <script>
      function posApp(){
        return {
          today: new Date().toISOString().slice(0,10),
          query: '',
          products: @json($products),
          cart: [],
          discount: 0,
          payment_method: 'cash',
          paid_amount: 0,
          checkoutError: '',

          format(n){ return 'Rp ' + (Number(n)||0).toLocaleString('id-ID'); },

          formatNumber(n){
            return (Number(n)||0).toLocaleString('id-ID');
          },

          parseNumber(str){
            return Number(String(str).replace(/\./g, '').replace(/,/g, '')) || 0;
          },

          search(){
            fetch("{{ route('pos.search') }}?q=" + encodeURIComponent(this.query))
              .then(r => r.json())
              .then(data => { this.products = data; })
              .catch(() => { this.products = []; });
          },

          addToCart(p){
            if(p.current_stock <= 0) return;
            const found = this.cart.find(x => x.product_id === p.id);
            if(found){
              if(found.qty < found.stock){
                found.qty += 1;
              } else {
                alert('Jumlah di keranjang sudah mencapai batas stok (' + found.stock + ').');
                return;
              }
            } else {
              this.cart.push({ product_id: p.id, name: p.name, price: Number(p.sell_price), qty: 1, stock: Number(p.current_stock) });
            }
            this.recalc();
          },

          capQty(idx){
            const c = this.cart[idx];
            if(c.qty < 1) c.qty = 1;
            if(c.qty > c.stock) c.qty = c.stock;
            this.recalc();
          },

          remove(i){
            this.cart.splice(i,1);
            this.recalc();
          },

          subtotal(){
            return this.cart.reduce((a,c)=> a + (Number(c.qty)||0) * (Number(c.price)||0), 0);
          },

          grandTotal(){
            return Math.max(0, this.subtotal() - (Number(this.discount)||0));
          },

          changeAmount(){
            return Math.max(0, (Number(this.paid_amount)||0) - this.grandTotal());
          },

          recalc(){
            if(this.payment_method === 'cash' && this.paid_amount === 0){
              this.paid_amount = this.grandTotal();
            }
          },

          submitCheckout(){
            this.checkoutError = '';
            if(this.cart.length === 0){
              this.checkoutError = 'Keranjang masih kosong.';
              return;
            }
            const gt = this.grandTotal();
            const paid = Number(this.paid_amount) || 0;
            if(paid < gt){
              this.checkoutError = 'Uang dibayar (Rp ' + this.formatNumber(paid) + ') kurang dari total (Rp ' + this.formatNumber(gt) + '). Silakan tambah pembayaran.';
              return;
            }
            document.querySelector('form[action="{{ route('sales.checkout') }}"]').submit();
          }
        }
      }
    </script>
</x-app-layout>
