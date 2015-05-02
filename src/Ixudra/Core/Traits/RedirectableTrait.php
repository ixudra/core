<?php namespace Ixudra\Core\Traits;


use Redirect;

Trait RedirectableTrait {

    protected function redirect($route = 'index', $parameters = array(), $messageType = '', $messages = array())
    {
        $redirectResponse = Redirect::route($route, $parameters);

        if( $messageType != '' ) {
            $redirectResponse = $redirectResponse
                ->with('messageType', $messageType)
                ->with('messages', $messages);
        }

        return $redirectResponse;
    }

}