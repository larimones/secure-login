<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
// Import Socialite
use Illuminate\Support\Facades\Auth; // Import Auth
use App\Models\User; // Import User model
use App\Http\Controllers\AuthController;

class GoogleAuthController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
{
    try {
        // Retrieve user from Google
        $google_user = Socialite::driver('google')->user(); // Corrected usage of stateless()

        // Debug Google user data
        if (!$google_user->getEmail() || !$google_user->getId()) {
            throw new \Exception('Google response is missing required fields.');
        }

        // Check if user exists in the database
        $user = User::where('google_id', $google_user->getId())->first();

        if (!$user) {
            $existing_user = User::where('email', $google_user->getEmail())->first();

            if ($existing_user) {
                // Attach Google ID to existing user
                $existing_user->update(['google_id' => $google_user->getId()]);
                $user = $existing_user;
            } else {
                // Create a new user
                $user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),

                ]);
            }
        }

        // Log in the user
        Auth::login($user);

        // Redirect to the intended dashboard route
        return redirect()->intended('welcome');
    } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
        dd('Invalid state: ' . $e->getMessage());
    } catch (\Throwable $th) {
        dd('An error occurred: ' . $th->getMessage());
    }
}

}