<?php namespace Ixudra\Core\Services\Html;


use Auth;
use View;
use Translate;

class BaseViewFactory {

    /** @var array $parameters  Parameters to passed along to the view */
    protected $parameters = array(
        'messageType'       => '',
        'messages'          => array(),
        'prefix'            => ''
    );


    /**
     * Add a notification for the user to the parameter array
     *
     * @param   string $type        Type of the notification
     * @param   array $messages     Array of message or translation keys that are to be shown to the user
     * @param   bool $translate     Indicate whether or not the messages should be translated
     */
    public function notifyUser($type, array $messages, $translate = true)
    {
        if( $translate ) {
            $messages = $this->translateMessages( $messages );
        }

        $this->addParameter( 'messageType', $type );
        $this->addParameter( 'messages', $messages );
    }

    /**
     * Add a parameter to the parameter array
     *
     * @param   string $key         Name of the parameter, as it should be known in the view
     * @param   mixed $value        Value of the of parameter
     */
    protected function addParameter($key, $value)
    {
        $this->parameters[ $key ] = $value;
    }

    /**
     * Add an array of parameters to the parameter array
     *
     * @param   array $parameterMap     Array of parameter, as they should be known in the view
     */
    protected function addParameterMap(array $parameterMap)
    {
        $this->parameters = array_merge(
            $this->parameters,
            $parameterMap
        );
    }

    /**
     * Create the view
     *
     * @param   string $view        Name of the template to be created
     * @return \Illuminate\Contracts\View\View
     */
    protected function makeView($view)
    {
        if( Auth::check() ) {
            $this->addParameter( 'activeUser', Auth::user() );
        }

        return View::make( $view, $this->parameters );
    }

    /**
     * Translate an array of messages
     *
     * @param   array $messages     Array of messages to be translated
     * @return array
     */
    protected function translateMessages(array $messages)
    {
        $results = array();
        foreach( $messages as $message ) {
            $results[] = Translate::message($message);
        }

        return $results;
    }

}

