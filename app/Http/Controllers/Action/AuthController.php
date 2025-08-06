<?php

namespace App\Http\Controllers\Action;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Login;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show Login Form
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('home.admin');
            } elseif ($user->role === 'customer') {
                return redirect()->route('home');
            }

            // fallback jika role tidak dikenal
            return redirect('/');
        }

        return view('auth.login');
    }


    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Throttle login attempts
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        $user = User::where('email', $request->email)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check((string) $request->password, (string) $user->password)) {
            RateLimiter::hit($this->throttleKey($request));
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        // Check if user registered with social media
        if ($user->provider && $user->provider !== 'email') {
            return back()->withErrors([
                'email' => 'Akun ini terdaftar dengan ' . ucfirst($user->provider) . '. Silakan login dengan metode tersebut.',
            ])->onlyInput('email');
        }

        // Update last login info
        $user->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $request->ip(),
            'login_count' => $user->login_count + 1,
        ]);

        Auth::login($user, $request->filled('remember'));
        event(new Login('web', $user, false));
        
        if ($user->role === 'admin') {
            return redirect()->route('home.admin');
        }

        $request->session()->regenerate();
        RateLimiter::clear($this->throttleKey($request));

        return redirect()->route('home');
    }

    // Show registration form
    public function showRegisterForm()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('home.admin');
            } elseif ($user->role === 'customer') {
                return redirect()->route('home');
            }

            // fallback jika role tidak dikenal
            return redirect('/');
        }
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'provider' => 'email',
            'provider_id' => null,
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
            'login_count' => 1,
            'role' => 'customer',
        ]);

        Auth::login($user, $request->filled('remember'));
        event(new Login('web', $user, false));

        if ($user->role === 'admin') {
            return redirect()->route('home.admin');
        }

        return redirect()->route('home');
    }


    // Redirect to Google
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')
                ->scopes(['openid', 'profile', 'email'])
                ->redirect();
        } catch (\Exception $e) {
            Log::error('Google redirect error: ' . $e->getMessage());
            return redirect()->route('register')
                ->withErrors(['socialite' => 'Gagal memulai login Google.']);
        }
    }

    // Google callback
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            Log::debug('Google User Data:', [
                'id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
                'raw' => $googleUser->getRaw()
            ]);

            if (!$googleUser->getEmail()) {
                throw new \Exception('Email tidak diberikan oleh Google');
            }

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                if ($user->provider !== 'google') {
                    return redirect()->route('register')
                        ->withErrors(['email' => 'Email ini sudah terdaftar dengan metode lain.']);
                }

                $updateData = [
                    'name' => $googleUser->getName(),
                    'provider_id' => $googleUser->getId(),
                    'last_login_at' => Carbon::now(),
                    'last_login_ip' => $request->ip(),
                    'login_count' => $user->login_count + 1,
                    'profile_picture' => $googleUser->getAvatar()
                ];

                Log::debug('Updating user with:', $updateData);
                $user->update($updateData);
            } else {
                $userData = [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)),
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'last_login_at' => Carbon::now(),
                    'last_login_ip' => $request->ip(),
                    'login_count' => 1,
                    'profile_picture' => $googleUser->getAvatar()
                ];

                Log::debug('Creating user with:', $userData);
                $user = User::create($userData);
            }

            Auth::login($user, true);
            
            if ($user->role === 'admin') {
                return redirect()->route('home.admin');
            }

            return redirect()->route('home');

        } catch (\Exception $e) {
            Log::error('Google callback error: ' . $e->getMessage());
            return redirect()->route('login')
                ->withErrors(['socialite' => 'Gagal masuk dengan Google: ' . $e->getMessage()]);
        }
    }

    // Redirect to Facebook
    public function redirectToFacebook()
    {
        try {
            return Socialite::driver('facebook')
                ->scopes(['email'])
                ->redirect();
        } catch (\Exception $e) {
            Log::error('Facebook redirect error: ' . $e->getMessage());
            return redirect()->route('register')
                ->withErrors(['socialite' => 'Gagal memulai login Facebook.']);
        }
    }

    // Facebook callback
    public function handleFacebookCallback(Request $request)
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            Log::debug('Facebook User Data:', [
                'id' => $facebookUser->getId(),
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail(),
                'avatar' => $facebookUser->getAvatar(),
                'raw' => $facebookUser->getRaw()
            ]);

            if (!$facebookUser->getEmail()) {
                throw new \Exception('Email tidak diberikan oleh Facebook');
            }

            $user = User::where('email', $facebookUser->getEmail())->first();

            if ($user) {
                if ($user->provider !== 'facebook') {
                    return redirect()->route('register')
                        ->withErrors(['email' => 'Email ini sudah terdaftar dengan metode lain.']);
                }

                $updateData = [
                    'name' => $facebookUser->getName(),
                    'provider_id' => $facebookUser->getId(),
                    'last_login_at' => Carbon::now(),
                    'last_login_ip' => $request->ip(),
                    'login_count' => $user->login_count + 1,
                    'profile_picture' => $facebookUser->getAvatar()
                ];

                Log::debug('Updating user with:', $updateData);
                $user->update($updateData);
            } else {
                $userData = [
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'password' => Hash::make(Str::random(24)),
                    'provider' => 'facebook',
                    'provider_id' => $facebookUser->getId(),
                    'email_verified_at' => now(),
                    'last_login_at' => Carbon::now(),
                    'last_login_ip' => $request->ip(),
                    'login_count' => 1,
                    'profile_picture' => $facebookUser->getAvatar()
                ];

                Log::debug('Creating user with:', $userData);
                $user = User::create($userData);
            }

            Auth::login($user, true);

            if ($user->role === 'admin') {
                return redirect()->route('home.admin');
            }

            return redirect()->route('home');

        } catch (\Exception $e) {
            Log::error('Facebook callback error: ' . $e->getMessage());
            return redirect()->route('login')
                ->withErrors(['socialite' => 'Gagal masuk dengan Facebook: ' . $e->getMessage()]);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Throttle helpers
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}