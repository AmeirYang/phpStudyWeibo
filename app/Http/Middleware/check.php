<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;


class check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request,Closure $next)
    {
        
        if($request->input('id')>1){
             
        }else{
            return response()->view('User/userWriteDB');
        }
        return $next($request);
    }


}
