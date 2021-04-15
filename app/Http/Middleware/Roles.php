<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Addpost;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() === null) {
            return redirect('/');
        }
        $actions = $request->route()->getAction();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;
        $userRole = Auth::user()->role;
        $response = in_array($userRole, $roles);

        if ($response) {
                        if (Auth::user()->role == "SuperAdmin") {
                // return redirect('/superadmin');
                return $next($request);
            }else {
                $addpost = Addpost::where('id', Auth::user()->schoolid)->get();

                // return response($addpost);
    
                if (count($addpost) > 0) {
    
                    if ($addpost[0]['status'] == "Pending" || $addpost[0]['status'] == "Expired") {
                        return redirect('home');
                    }else{
                        return $next($request);
                    }
                }
            }
            
        }else{
            if (Auth::user()->role == "SuperAdmin") {
                return redirect('/superadmin');
            }else{
                return redirect('/home');
            }
            
        }
        return response('No authorization', 401);
    }
}
