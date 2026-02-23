<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TokoBangunPOS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding Panel -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 relative overflow-hidden">
                <!-- Pattern overlay -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)"/>
                    </svg>
                </div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-center items-center w-full px-12">
                    <!-- Logo -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 mb-8">
                        <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>

                    <h1 class="text-4xl font-bold text-white mb-2">
                        TokoBangun<span class="text-primary-200">POS</span>
                    </h1>
                    <p class="text-primary-200 text-lg text-center max-w-sm">
                        Sistem Kasir & Manajemen Toko Bangunan Modern
                    </p>

                    <!-- Features -->
                    <div class="mt-12 space-y-4 text-white/80">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 rounded-lg p-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span>Point of Sale cepat & mudah</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 rounded-lg p-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span>Manajemen stok real-time</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 rounded-lg p-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span>Laporan & analisis lengkap</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form Panel -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12 bg-gray-50">
                <!-- Mobile Logo (shown only on small screens) -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="inline-flex bg-primary-600 rounded-xl p-4 mb-4">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        TokoBangun<span class="text-primary-600">POS</span>
                    </h1>
                </div>

                <div class="w-full sm:max-w-md">
                    <div class="bg-white shadow-xl border border-gray-200 rounded-2xl px-8 py-10">
                        {{ $slot }}
                    </div>

                    <p class="text-center text-xs text-gray-400 mt-6">
                        &copy; {{ date('Y') }} TokoBangunPOS. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
