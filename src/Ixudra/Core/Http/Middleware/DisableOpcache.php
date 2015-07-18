<?php namespace Ixudra\Core\Http\Middleware;


use Closure;

class DisableOpcache {

    public function handle($request, Closure $next)
    {
        if( env('APP_ENV') != 'production' ) {
            opcache_reset();
        }

        return $next( $request );
    }

}
