<?php namespace Ixudra\Core\Http\Middleware;


use Closure;

class DisableOpcache {

    /**
     * Resets the opcache if it is available on the server and if we are not on a production server. This can be very
     * useful for you are working locally and you don't want to deal with cached responses from the server. This
     * feature is excluded from production environments since it is typically desired to use as much caching as
     * possible in order to improve the user experience
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( env('APP_ENV') !== 'production' && function_exists( 'opcache_reset' ) ) {
            opcache_reset();
        }

        return $next( $request );
    }

}
