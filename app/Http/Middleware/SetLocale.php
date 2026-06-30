<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->query('locale', Session::get('locale', config('app.locale')));

        if (!in_array($locale, config('app.supported_locales'))) {
            $locale = config('app.locale');
        }

        if ($request->has('locale') && in_array($request->query('locale'), config('app.supported_locales'))) {
            Session::put('locale', $locale);
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        view()->share('currentLocale', $locale);
        view()->share('isRtl', in_array($locale, config('app.rtl_locales', ['ar'])));

        return $next($request);
    }
}
