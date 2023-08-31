<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApplyUserPreferences
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $supported = ['en','ar'];
        $locales = explode(',',$request->header('accept-language'));
        $locale = config('app.locale');
        
        if($locales){
            foreach ($locales as  $locale) {
                if(($i =  strpos($locale,';') ) !== false){
                    $locale = substr($locale,0,$i);
                }
                if(in_array($locale,$supported)){
                   // $locale = config('app.locale');
                    break;
                }
            }
        }
      
       
         $user = Auth::user();
        if($user){
            $locale = $user->profile->locale ?? $locale;
        } 
        //dd($locale);
        App::setLocale($locale);
        return $next($request);
    }
}
