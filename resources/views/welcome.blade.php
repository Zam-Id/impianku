<x-layout>
    <x-slot:title>Selamat Datang di ImpianKu</x-slot:title>

    <div class="min-h-[75vh] flex flex-col items-center justify-center text-center px-4">
        
        <div class="mb-8">
            <img src="{{ asset('logo.png') }}" alt="Logo ImpianKu" class="w-28 h-28 md:w-36 md:h-36 object-contain drop-shadow-xl mx-auto hover:scale-110 transition-transform duration-300 animate-[bounce_3s_infinite]">
        </div>
        
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-6">
            Wujudkan <span class="bg-gradient-to-r from-impian-500 to-impian-700 dark:from-impian-300 dark:to-impian-500 bg-clip-text text-transparent drop-shadow-sm">Impianmu</span> Sekarang!
        </h1>
        
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-10 leading-relaxed font-medium">
            Catat setiap target mimpimu, jadikan sebagai "hutang" yang wajib dilunasi, dan pantau proses menabungmu setiap hari dengan cara yang menyenangkan.
        </p>

        <a href="{{ route('google.login') }}" class="group flex items-center justify-center gap-3 md:gap-4 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 px-6 py-3 md:px-8 md:py-4 rounded-xl md:rounded-2xl text-base md:text-lg font-bold hover:border-impian-400 dark:hover:border-impian-500 hover:shadow-xl transition-all duration-300 active:scale-95 text-gray-800 dark:text-gray-200 w-full max-w-[280px] md:max-w-sm mx-auto shadow-sm">
            <svg class="w-6 h-6 md:w-7 md:h-7 group-hover:scale-110 transition-transform" viewBox="0 0 24 24">
                <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Lanjutkan dengan Google
        </a>
        
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-6 flex items-center justify-center gap-1 font-medium">
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            Aman, cepat, dan otomatis menyimpan datamu.
        </p>
    </div>
</x-layout>