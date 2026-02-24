<x-layout>
    <x-slot:title>Dashboard - ImpianKu</x-slot:title>

    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Impianku</h1>
            <p class="text-gray-600 dark:text-gray-400">Jadikan impianmu sebagai hutang yang wajib dilunasi!</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8 transition-colors duration-300">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Buat Target Impian Baru</h2>
        
        <form action="{{ route('impian.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Impian</label>
                <input type="text" name="nama_impian" required placeholder="Contoh: Beli Laptop Baru" 
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-impian-500 tabular-nums tracking-tight">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                <select name="kategori_id" required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-impian-500 tabular-nums tracking-tight">
                    <option value="" disabled selected>Pilih Kategori...</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}">{{ $k->icon_svg }} {{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div x-data="{ 
                    rawAngka: '', 
                    get formatted() {
                        if (!this.rawAngka) return '';
                        return new Intl.NumberFormat('id-ID').format(this.rawAngka);
                    },
                    set formatted(value) {
                        this.rawAngka = String(value).replace(/[^0-9]/g, '');
                    }
                }">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Dana (Rp)</label>
                
                <input type="text" x-model="formatted" required placeholder="1.000.000" 
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-impian-500 tabular-nums tracking-tight">
                
                <input type="hidden" name="target_dana" x-bind:value="rawAngka">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jatuh Tempo (Tenggat Waktu)</label>
                <input type="text" name="jatuh_tempo" required placeholder="Pilih tanggal target..." 
                    x-data 
                    x-init="flatpickr($el, { 
                        locale: 'id', 
                        minDate: new Date().fp_incr(1), // Memaksa user hanya bisa pilih mulai besok
                        dateFormat: 'Y-m-d', // Format yang dikirim ke database
                        altInput: true,      // Menampilkan input virtual yang lebih cantik
                        altFormat: 'j F Y',  // Format yang dilihat user (Contoh: 25 Februari 2026)
                        disableMobile: 'true' // Memaksa kalender kustom ini muncul di semua HP
                    })"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-impian-500 tabular-nums tracking-tight dark:bg-gray-700 cursor-pointer">
            </div>

            <div class="md:col-span-2 flex justify-end mt-2">
                <button type="submit" class="bg-gradient-to-r from-impian-300 to-impian-500 hover:from-impian-500 hover:to-impian-300 text-gray-900 font-bold py-2 px-6 rounded-lg shadow-sm transition-all active:scale-95 duration-200">
                    Simpan Impian
                </button>
            </div>
        </form>
    </div>

    <div class="mt-12">
        <h2 class="text-xl font-bold mb-6 text-gray-900 dark:text-white">Daftar Impian Berjalan</h2>

        @if($impians->isEmpty())
            <div class="text-center py-10 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <span class="text-4xl mb-4 block">📭</span>
                <p class="text-gray-500 dark:text-gray-400">Belum ada impian yang dicatat. Yuk, mulai buat impian pertamamu!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($impians as $impian)
                    <div x-data="{ modalOpen: false }" class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-300 relative overflow-hidden">
                        
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-impian-100 dark:bg-impian-900/30 flex items-center justify-center text-xl shadow-sm border border-impian-300/50">
                                    {{ $impian->kategori->icon_svg }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white line-clamp-1">{{ $impian->nama_impian }}</h3>
                                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                        {{ $impian->kategori->nama_kategori }}
                                    </span>
                                </div>
                            </div>
                            @if($impian->status == 'tercapai')
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">LUNAS 🎉</span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Target Dana:</p>
                            <p class="text-2xl font-extrabold text-impian-700 dark:text-impian-300 tabular-nums tracking-tight">
                                Rp {{ number_format($impian->target_dana, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-500 dark:text-gray-400">Terkumpul: Rp {{ number_format($impian->terkumpul, 0, ',', '.') }}</span>
                                <span class="font-bold text-gray-700 dark:text-gray-300">{{ $impian->progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden shadow-inner">
                                <div class="bg-gradient-to-r from-impian-300 to-impian-500 h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: {{ $impian->progress }}%"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-end border-t border-gray-100 dark:border-gray-700 pt-4 mt-2 gap-2">
                            <div class="text-sm">
                                @php
                                    $selisih = \Carbon\Carbon::now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($impian->jatuh_tempo)->startOfDay(), false);
                                @endphp
                                
                                @if($impian->status == 'berjalan')
                                    @if($selisih > 0)
                                        <span class="text-impian-600 dark:text-impian-400 font-bold block text-xs mb-1">
                                            ⏳ {{ (int)$selisih }} hari lagi impianmu terwujud!
                                        </span>
                                    @elseif($selisih == 0)
                                        <span class="text-orange-500 dark:text-orange-400 font-bold block text-xs mb-1">
                                            🔥 Hari ini batas waktunya!
                                        </span>
                                    @else
                                        <span class="text-red-600 dark:text-red-400 font-bold block text-xs mb-1">
                                            ⚠️ Terlewat {{ abs((int)$selisih) }} hari
                                        </span>
                                    @endif
                                @endif

                                <span class="text-gray-500 dark:text-gray-400 block text-xs">Jatuh Tempo:</span>
                                <span class="font-medium text-red-500 dark:text-red-400">
                                    {{ \Carbon\Carbon::parse($impian->jatuh_tempo)->translatedFormat('d F Y') }}
                                </span>
                            </div> 
                            @if($impian->status == 'berjalan')
                                <button @click="modalOpen = true" class="shrink-0 bg-gradient-to-r from-impian-100 to-impian-300 text-gray-900 hover:shadow-md px-4 py-2 rounded-lg text-sm font-bold transition-all active:scale-95 border border-impian-400 mb-1">
                                    Cicil
                                </button>
                            @endif
                        </div>

                        <template x-teleport="body">
                            <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50 backdrop-blur-sm" style="display: none;">
                                <div x-show="modalOpen" @click.away="modalOpen = false" 
                                     x-transition:enter="transition ease-out duration-300" 
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                     x-transition:leave="transition ease-in duration-200" 
                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                     class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100 dark:border-gray-700">
                                    
                                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Bayar Cicilan Impian</h3>
                                        <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none text-2xl">&times;</button>
                                    </div>

                                    <form action="{{ route('transaksi.store', $impian->id) }}" method="POST" class="p-6">
                                        @csrf
                                        
                                        <div class="mb-4" x-data="{ 
                                                rawAngka: '', 
                                                get formatted() { return this.rawAngka ? new Intl.NumberFormat('id-ID').format(this.rawAngka) : ''; },
                                                set formatted(value) { this.rawAngka = String(value).replace(/[^0-9]/g, ''); }
                                            }">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nominal Cicilan (Rp)</label>
                                            <input type="text" x-model="formatted" required placeholder="Contoh: 50.000" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-impian-500 tabular-nums tracking-tight">
                                            <input type="hidden" name="nominal" x-bind:value="rawAngka">
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Bayar</label>
                                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-impian-500 tabular-nums tracking-tight">
                                        </div>

                                        <div class="mb-6">
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan (Opsional)</label>
                                            <input type="text" name="keterangan" placeholder="Hasil nabung minggu ini..." class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-impian-500 tabular-nums tracking-tight">
                                        </div>

                                        <div class="flex justify-end gap-3">
                                            <button type="button" @click="modalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-lg transition-colors">Batal</button>
                                            <button type="submit" class="px-4 py-2 text-sm font-bold text-gray-900 bg-gradient-to-r from-impian-300 to-impian-500 hover:from-impian-500 hover:to-impian-300 rounded-lg shadow-sm transition-all active:scale-95 duration-200">
                                                Simpan Cicilan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </template>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>