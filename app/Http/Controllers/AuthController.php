<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Processa o login do usuário.
     */
    public function login(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8', // Mínimo de 8 caracteres
                'regex:/[a-z]/', // Pelo menos uma letra minúscula
                'regex:/[A-Z]/', // Pelo menos uma letra maiúscula
                'regex:/[0-9]/', // Pelo menos um número
                'regex:/[@$!%*?&#]/', // Pelo menos um caractere especial
            ],
        ]);

        // Verifica credenciais e autentica o usuário
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate(); // Previne hijacking de sessão
            Log::info('Usuário logado com sucesso.', ['email' => $request->email]);
            return redirect()->intended('dashboard');
        }

        // Log de falha de login
        Log::warning('Tentativa de login falhou.', ['email' => $request->email]);

        // Lança exceção para falha de credenciais
        throw ValidationException::withMessages([
            'email' => ['As credenciais fornecidas estão incorretas.'],
        ]);
    }

    /**
     * Realiza o logout do usuário.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // Invalida a sessão atual
        $request->session()->regenerateToken(); // Previne reutilização de tokens

        Log::info('Usuário deslogado com sucesso.');
        return redirect('/');
    }

    /**
     * Exibe o formulário de recuperação de senha.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envia o link de redefinição de senha.
     */
    public function sendPasswordResetLink(Request $request)
    {
        // Valida o e-mail
        $request->validate(['email' => 'required|email']);

        // Tenta enviar o link de redefinição
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            Log::info('Link de redefinição de senha enviado.', ['email' => $request->email]);
            return back()->with('status', 'Enviamos um link de redefinição de senha para o seu e-mail!');
        }

        Log::warning('Falha ao enviar link de redefinição.', ['email' => $request->email]);
        return back()->withErrors(['email' => 'Não conseguimos enviar o link de redefinição. Tente novamente mais tarde.']);
    }

}
