<x-layout>
    <x-slot:title>Edit Profil - ImpianKu</x-slot:title>

    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Pengaturan Profil</h2>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')
            
            <div class="flex justify-center mb-6">
                <img id="image-preview" src="{{ auth()->user()->avatar }}" class="w-24 h-24 rounded-full border-4 border-impian-300 object-cover shadow-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-impian-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Foto Profil Baru</label>
                <input type="file" name="avatar" accept="image/*" 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-impian-100 file:text-impian-700 hover:file:bg-impian-200"
                    onchange="
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('image-preview').src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    ">
                <p class="text-xs text-gray-500 mt-1">*Format: JPG, PNG atau WebP (Maks 2MB)</p>
                
                @error('avatar')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <a href="{{ route('dashboard') }}" class="flex-1 text-center py-2 px-4 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Batal</a>
                <button type="submit" class="flex-1 py-2 px-4 rounded-lg bg-gradient-to-r from-impian-300 to-impian-500 hover:from-impian-500 hover:to-impian-300 text-gray-900 font-bold shadow-sm active:scale-95 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-layout>