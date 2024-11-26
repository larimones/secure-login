<?php
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Usuário já existe, faça login
                Auth::login($user);
            } else {
                // Usuário não existe, crie um novo
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)), // Senha aleatória
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(16)), // Senha aleatória
                ]);

                Auth::login($user);
            }
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);
            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Erro ao autenticar com o Google']);
        }
    }
}