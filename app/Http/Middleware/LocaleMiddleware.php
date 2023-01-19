<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    // available language in template array
    $availLocale = ['ar' => 'ar', 'en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'];

    // Locale is enabled and allowed to be change
    if (array_key_exists($request->segment(2), $availLocale)) {
      // Set the Laravel locale
      app()->setLocale($request->segment(2));
    }

    return $next($request);
  }
}
