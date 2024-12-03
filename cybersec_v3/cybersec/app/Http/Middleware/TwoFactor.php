<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;

// class TwoFactor
// {
//  /**
//      * Handle an incoming request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function handle(Request $request, Closure $next)
//     {
//         $user = auth()->user();

//         if (auth()->check() && $user->two_factor_code){

//             if($user->two_factor_expires_at->lt(now())){
//                 $user->logout();
//                 return response()->json(['error' => 'Code expired.'],403);
//             }
//             if(!$request->is('verify*')){
//                 return redirect()->route('verify.index');
//                 // return response()->json(['error' => 'Please verify your account.'],403);

//             }
//         }

//         return $next($request);
//     }
// }
