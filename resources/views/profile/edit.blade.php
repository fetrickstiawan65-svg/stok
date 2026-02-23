<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="bg-primary-100 rounded-lg p-2">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h2 class="font-semibold text-2xl text-gray-900">Profil Saya</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-card>
                @include('profile.partials.update-profile-information-form')
            </x-card>

            <x-card>
                @include('profile.partials.update-password-form')
            </x-card>

            <x-card>
                @include('profile.partials.delete-user-form')
            </x-card>
        </div>
    </div>
</x-app-layout>
