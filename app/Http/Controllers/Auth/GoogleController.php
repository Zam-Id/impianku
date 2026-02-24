<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada di database berdasarkan email
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Jika user sudah ada, pastikan google_id terisi, tapi JANGAN timpa avatarnya 
                // agar foto yang sudah diupload ke Supabase tidak hilang
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {
                // Jika user belum ada sama sekali, buat baru dengan data dari Google
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null
                ]);
            }

            // Login otomatis
            Auth::login($user, true);

            // Arahkan ke halaman utama setelah login
            return redirect('/');

        } catch (Exception $e) {
            return redirect('/')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }

    public function editProfile() 
    {
        return view('profile-edit');
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        // 1. Deteksi Perubahan (Nama & Foto)
        $gantiNama = $user->name !== $request->name;
        $gantiFoto = $request->hasFile('avatar');

        // 2. Siapkan Pesan Pop-up Berdasarkan Perubahan
        $pesan = "";
        if ($gantiNama && $gantiFoto) {
            $pesan = "Nama dan Foto Profil berhasil diubah!<br>Silakan cek kembali pembaruannya.";
        } elseif ($gantiFoto) {
            $pesan = "Foto Profil berhasil diubah!<br>Silakan cek kembali pembaruannya.";
        } elseif ($gantiNama) {
            $pesan = "Nama berhasil diubah!<br>Silakan cek kembali pembaruannya.";
        } else {
            // Jika klik simpan tapi tidak mengubah apa-apa
            return redirect('/')->with('info', 'Tidak ada perubahan pada profil.');
        }

        $updateData = ['name' => $request->name];

        if ($gantiFoto) {
            $file = $request->file('avatar');
            $fileName = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
            $supabaseKey = env('SUPABASE_KEY');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $supabaseKey,
                'apikey'        => $supabaseKey,
                'x-upsert'      => 'true',
            ])->attach(
                'file', 
                file_get_contents($file->getRealPath()), 
                $fileName,
                ['Content-Type' => $file->getMimeType()]
            )->post($supabaseUrl . '/storage/v1/object/avatars/' . $fileName);

            if ($response->successful()) {
                $updateData['avatar'] = $supabaseUrl . '/storage/v1/object/public/avatars/' . $fileName;
            } else {
                return back()->with('error', 'Gagal upload foto ke Supabase.');
            }
        }

        $user->update($updateData);

        // 3. Redirect ke Dashboard sambil membawa pesan 'popup_success'
        return redirect('/')->with('popup_success', $pesan);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}