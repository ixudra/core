<?php namespace Ixudra\Core\Traits;


use Symfony\Component\HttpFoundation\RedirectResponse;

use Redirect;

Trait RedirectableTrait {

    /**
     * Redirect to a specific. If desired, a message can be passed along to the request
     *
     * @param   string $route
     * @param   array $parameters
     * @param   string $messageType
     * @param   array $messages
     * @return RedirectResponse
     */
    protected function redirect($route = 'index', $parameters = array(), $messageType = '', $messages = array())
    {
        $redirectResponse = Redirect::route($route, $parameters);

        if( $messageType !== '' ) {
            $redirectResponse = $redirectResponse
                ->with('messageType', $messageType)
                ->with('messages', $messages);
        }

        return $redirectResponse;
    }

}