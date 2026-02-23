<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Satuan Barang</h2>
            <x-button variant="primary" href="{{ route('units.create') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Satuan
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
                                <th class="py-3 px-4 font-semibold text-gray-700">Nama Satuan</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Simbol</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-center w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($items as $u)
                                <tr class="hover:bg-gray-50 transition-colors {{ $loop->iteration % 2 == 0 ? 'bg-gray-25' : 'bg-white' }}">
                                    <td class="py-3 px-4">
                                        <span class="font-medium text-gray-900">{{ $u->name }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <x-badge color="primary" size="sm">{{ $u->symbol }}</x-badge>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('units.edit',$u) }}" 
                                               class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-primary-700 hover:text-primary-900 hover:bg-primary-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('units.destroy',$u) }}" 
                                                  onsubmit="return confirm('Hapus satuan {{ $u->name }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-red-700 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada satuan</p>
                                        <p class="text-gray-400 text-sm mt-1">Silakan tambah satuan barang baru</p>
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
