<?php
 namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Services\MailjetService;

    class TwoFactorController extends Controller
    {

        public function index(){
            return view('auth.twoFactor');
        }

        public function verify(Request $request)
        {
            $request->validate([
                'twoFactor' => 'integer|required'
            ]);
            $user = Auth::user();

            if($request->twoFactor == $user->two_factor_code) {

                return redirect()->intended('dashboard');
            }
            else {
                return back()->withErrors(['two_factor_code' => 'The two factor code provided was invalid.']);
            }
        }

        public function send()
        {
            $user = Auth::user();
            $recipientEmail = $user->email;
            $mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
            $code = rand(100000, 999999);
            User::where([
                'email' => $user->email,
            ])->update([
                'two_factor_code' => $code,
                'two_factor_expires_at' => null,
            ]);

            // envia o email
            $mj = new MailjetService();
            $mj->send($recipientEmail, $user->name, $code);

            return back();
        }

    }