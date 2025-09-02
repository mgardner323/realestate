<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the application has been installed
        $isInstalled = file_exists(base_path('.installed')) || config('site.installed');
        
        // If not installed, redirect to installation wizard
        if (!$isInstalled && !$request->is('install*')) {
            return redirect('/install');
        }
        
        // If already installed, don't allow access to installation routes
        if ($isInstalled && $request->is('install*')) {
            return redirect('/');
        }
        
        return $next($request);
    }
}
