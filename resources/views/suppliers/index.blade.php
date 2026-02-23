<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900">Data Supplier</h2>
            <x-button variant="primary" href="{{ route('suppliers.create') }}">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Supplier
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
                                <th class="py-3 px-4 font-semibold text-gray-700">Nama Supplier</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Telepon</th>
                                <th class="py-3 px-4 font-semibold text-gray-700">Alamat</th>
                                <th class="py-3 px-4 font-semibold text-gray-700 text-center w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($items as $s)
                                <tr class="hover:bg-gray-50 transition-colors {{ $loop->iteration % 2 == 0 ? 'bg-gray-25' : 'bg-white' }}">
                                    <td class="py-3 px-4">
                                        <span class="font-medium text-gray-900">{{ $s->name }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-gray-700">{{ $s->phone }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="text-gray-600 text-sm">{{ $s->address }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('suppliers.edit',$s) }}" 
                                               class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-primary-700 hover:text-primary-900 hover:bg-primary-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('suppliers.destroy',$s) }}" 
                                                  onsubmit="return confirm('Hapus supplier {{ $s->name }}?')">
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
                                    <td colspan="4" class="py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada supplier</p>
                                        <p class="text-gray-400 text-sm mt-1">Silakan tambah supplier baru</p>
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
