<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'staff') {
            return $next($request);
        }
        return redirect()->route('dashboard')
            ->with('error', 'Access denied!');
    }
}