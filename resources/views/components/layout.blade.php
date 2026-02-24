<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ImpianKu' }}</title>
    <meta name="theme-color" content="#4f46e5">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200 antialiased transition-colors duration-300">
    
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2 group">
                        <img src="{{ asset('logo.png') }}" alt="Logo ImpianKu" class="w-8 h-8 md:w-10 md:h-10 object-contain drop-shadow-sm transition-transform duration-300 group-hover:scale-110">
                        
                        <span class="text-2xl md:text-3xl font-extrabold tracking-tight bg-gradient-to-r from-impian-500 to-impian-700 dark:from-impian-300 dark:to-impian-500 bg-clip-text text-transparent drop-shadow-sm">
                            ImpianKu
                        </span>
                    </a>
                </div>
                
                <div class="flex items-center relative">
                    @auth
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none transition-transform active:scale-95">
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-9 h-9 rounded-full border border-indigo-200 shadow-sm" referrerpolicy="no-referrer">
                            <span class="hidden md:block text-sm font-medium dark:text-gray-300">{{ auth()->user()->name }}</span>
                        </button>

                        <div x-show="open" 
                             @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 top-14 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-2 ring-1 ring-black ring-opacity-5 z-50 border border-gray-100 dark:border-gray-700"
                             style="display: none;">
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profil Saya</a>
                            
                            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
@if (session('popup_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    html: `{!! session('popup_success') !!}`,
                    confirmButtonText: 'Siap Lanjutkan!',
                    buttonsStyling: false,
                    backdrop: `rgba(0,0,0,0.6)`,
                    customClass: {
                        popup: 'bg-white/95 backdrop-blur-sm dark:bg-gray-800/95 rounded-3xl shadow-2xl border border-gray-100/50 dark:border-gray-700/50 p-6 sm:p-8 w-full max-w-sm !important',
                        title: 'text-2xl font-extrabold text-gray-900 dark:text-white pt-2',
                        htmlContainer: 'text-gray-600 dark:text-gray-300 text-sm sm:text-base mt-2',
                        confirmButton: 'mt-6 w-full bg-gradient-to-r from-impian-300 to-impian-500 hover:from-impian-400 hover:to-impian-600 text-gray-900 font-bold py-3 px-6 rounded-xl shadow-lg shadow-impian-200/50 hover:shadow-xl transition-all active:scale-95 duration-200 focus:outline-none focus:ring-2 focus:ring-impian-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800'
                    }
                });
            });
        </script>
    @endif


@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Waduh, Gagal!',
                html: `{!! session('error') !!}`,
                confirmButtonText: 'Tutup',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white/95 backdrop-blur-sm dark:bg-gray-800/95 rounded-3xl shadow-2xl border border-red-100/50 dark:border-red-900/50 p-6 sm:p-8 w-full max-w-sm !important',
                    title: 'text-2xl font-extrabold text-gray-900 dark:text-white pt-2',
                    htmlContainer: 'text-gray-600 dark:text-gray-300 text-sm sm:text-base mt-2',
                    confirmButton: 'mt-6 w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-red-200/50 hover:shadow-xl transition-all active:scale-95 duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800'
                }
            });
        });
    </script>
@endif


@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '<li class="mb-1 text-red-600 dark:text-red-400">{{ $error }}</li>';
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Cek Lagi Datanya!',
                html: `<ul class="text-left list-disc pl-5 text-sm mt-2">${errorMessages}</ul>`,
                confirmButtonText: 'Baik, Saya Perbaiki',
                buttonsStyling: false,
                backdrop: `rgba(0,0,0,0.6)`,
                customClass: {
                    popup: 'bg-white/95 backdrop-blur-sm dark:bg-gray-800/95 rounded-3xl shadow-2xl border border-red-100/50 dark:border-red-900/50 p-6 sm:p-8 w-full max-w-md !important',
                    title: 'text-2xl font-extrabold text-gray-900 dark:text-white pt-2',
                    htmlContainer: 'mt-2',
                    confirmButton: 'mt-6 w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-red-200/50 hover:shadow-xl transition-all active:scale-95 duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800'
                }
            });
        });
    </script>
@endif


        {{ $slot }}
    </main>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker sukses didaftarkan dengan scope: ', registration.scope);
                    })
                    .catch(err => {
                        console.log('ServiceWorker gagal didaftarkan: ', err);
                    });
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>