<?php namespace Ixudra\Core\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Redirect;

abstract class BaseController extends Controller {

    use DispatchesCommands, ValidatesRequests;


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
