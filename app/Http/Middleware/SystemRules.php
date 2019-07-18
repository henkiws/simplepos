<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class SystemRules
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {   
        $dt = session('isLogin');
        if($dt){
            $user = User::find($dt['id']);
            if($user->hasRole($role)){
                return $next($request);
            }else{
                if($role == "admin"){
                    return redirect('kasir');    
                }elseif($role == "kasir"){
                    return redirect('admin');    
                }
            }
        }else{
            return redirect('/');
        }
    }
}
