<?php
 namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Services\MailjetService;
    use Carbon\Carbon;

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

            if (Carbon::now()->greaterThan($user->two_factor_expires_at)) {
                return response()->json(['message' => 'O código de autenticação de dois fatores expirou.'], 403);
             } else {
                if($request->twoFactor == $user->two_factor_code) {
                    //verifica se é admin
                    if ($user->is_admin) {
                        return redirect()->intended('admin-dashboard');
                    }
                    return redirect()->intended('dashboard');
                }
                else {
                    return back()->withErrors(['two_factor_code' => 'The two factor code provided was invalid.']);
                }
             }
        }

        public function send()
        {
            $user = Auth::user();
            $recipientEmail = $user->email;
            $mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'),
            getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
            $code = rand(100000, 999999);
            User::where([
                'email' => $user->email,
            ])->update([
                'two_factor_code' => $code,
                'two_factor_expires_at' => Carbon::now()->addMinutes(10),
            ]);

            $mj = new MailjetService();
            $mj->send($recipientEmail, $user->name, $code);

            return back();
        }

    }