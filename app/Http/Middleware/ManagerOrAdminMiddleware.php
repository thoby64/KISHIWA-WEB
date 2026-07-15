<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerOrAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/secure-login');
        }
        
        $user = Auth::user();
        
        if ($user->role !== 'admin' && $user->role !== 'manager') {
            abort(403, 'Unauthorized');
        }
        
        return $next($request);
    }
}
