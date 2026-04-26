<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'pin' => 'required',
        ]);

        $user = RoleUsers::where('email', $request->email)->first();

        // Debug logging
        Log::info('Login attempt', [
            'email' => $request->email,
            'user_found' => $user ? 'yes' : 'no',
            'user_role' => $user ? $user->role : 'N/A',
            'pin_input' => $request->pin,
            'pin_length' => strlen($request->pin),
        ]);

        if ($user) {
            $pinValid = Hash::check($request->pin, $user->pin);
            Log::info('PIN validation', [
                'pin_valid' => $pinValid ? 'yes' : 'no',
                'stored_hash' => substr($user->pin, 0, 20) . '...',
            ]);
            
            if ($pinValid) {
            
            Log::info('PIN valid, role: ' . $user->role);

            switch ($user->role) {
                case 'admin':
                    Auth::login($user);
                    return redirect()->route('admin.home');
                case 'supervisor':
                    Auth::login($user);
                    return redirect()->route('supvis.home');
                case 'sales':
                    Auth::login($user);
                    return redirect()->route('sales.home');
                case 'pelanggan':
                    Auth::login($user);
                    Log::info('Pelanggan logged in, redirecting to pelanggan.home');
                    return redirect()->route('pelanggan.home');
                default:
                    Log::warning('Invalid role: ' . $user->role);
                    return back()->withErrors(['role' => 'Role tidak valid untuk mengakses halaman ini.']);
            }
        } else {
            Log::warning('PIN validation failed for user: ' . $user->email);
        }
        } else {
            Log::warning('User not found for email: ' . $request->email);
        }

        Log::warning('Login failed for email: ' . $request->email);
        return back()->withErrors(['email' => 'Email atau PIN tidak valid.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        try {
            // Validate the registration form data
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:role_users,email',
                'nomor_hp' => 'required|string|max:20',
                'tempat_tugas' => 'required|string|max:255',
                'pin' => 'required|string|min:6|max:20',
                'pin_confirmation' => 'required|string|same:pin',
            ], [
                'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
                'pin.min' => 'PIN minimal 6 karakter.',
                'pin_confirmation.same' => 'Konfirmasi PIN tidak cocok.',
                'nama.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'nomor_hp.required' => 'Nomor HP wajib diisi.',
                'tempat_tugas.required' => 'Alamat wajib diisi.',
                'pin.required' => 'PIN wajib diisi.',
                'pin_confirmation.required' => 'Konfirmasi PIN wajib diisi.',
            ]);

            // Create new user with pelanggan role - using correct database field names
            // Note: PIN akan di-hash otomatis oleh mutator setPinAttribute di model
            $user = RoleUsers::create([
                'name' => $validatedData['nama'],        // nama -> name
                'email' => $validatedData['email'],
                'phone' => $validatedData['nomor_hp'],   // nomor_hp -> phone
                'tempat_tugas' => $validatedData['tempat_tugas'],
                'pin' => $validatedData['pin'],          // Plain text PIN, biarkan mutator yang hash
                'role' => 'pelanggan',
            ]);

            Log::info('New user registered', [
                'email' => $user->email,
                'nama' => $user->name,
                'role' => $user->role,
            ]);

            // Auto login the new user
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil! Anda akan dialihkan ke halaman utama.',
                'redirect' => route('pelanggan.home')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang dimasukkan tidak valid.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pendaftaran. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Redirect user to Google OAuth page
     */
    public function redirectToGoogle()
    {
        Log::info("Google redirect initiated");
        return Socialite::driver("google")->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            Log::info('Google callback triggered');
            // Get user info from Google (stateless for development)
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            Log::info('Google OAuth callback', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
            ]);

            // Find or create user
            $user = RoleUsers::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // User exists - login
                Log::info('Existing Google user logging in', [
                    'email' => $user->email,
                    'role' => $user->role,
                ]);

                // Only allow pelanggan role to login via Google
                if ($user->role !== 'pelanggan') {
                    return redirect()->route('login')->withErrors([
                        'email' => 'Akun ini tidak dapat login menggunakan Google. Silakan gunakan email dan PIN.'
                    ]);
                }

                Auth::login($user);
                return redirect()->route('pelanggan.home');

            } else {
                // New user - create account
                $user = RoleUsers::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'phone' => '', // Can be filled later in profile
                    'tempat_tugas' => '', // Can be filled later in profile
                    'pin' => Hash::make(uniqid()), // Random PIN for Google users (not used)
                    'role' => 'pelanggan',
                    'photo' => $googleUser->getAvatar(),
                ]);

                Log::info('New Google user registered', [
                    'email' => $user->email,
                    'name' => $user->name,
                ]);

                Auth::login($user);
                
                // Redirect to profile to complete information
                return redirect()->route('pelanggan.home')->with('success', 'Akun berhasil dibuat! Silakan lengkapi profil Anda.');
            }

        } catch (Exception $e) {
            Log::error('Google OAuth error', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('login')->withErrors([
                'email' => 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.'
            ]);
        }
    }
}


