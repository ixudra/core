<?php namespace Ixudra\Core\Presenters;


use Translate;

use Laracasts\Presenter\Presenter;

class BasePresenter extends Presenter {

    /**
     * Translate a boolean value into a translation string
     *
     * @param       mixed $value        The value to be translated
     * @return string
     */
    protected function truthy($value)
    {
        $key = 'no';
        if( $value ) {
            $key = 'yes';
        }

        return Translate::recursive('common.'. $key);
    }

    /**
     * Return a short version of a strings
     *
     * @param       string $string      The string to be shortened
     * @param       int $length         The maximum length of the string that is to be shown
     * @return string
     */
    protected function short($string, $length = 200)
    {
        if( strlen( $string ) < $length ) {
            return $string;
        }

        return substr( $string, 0, $length ) .'...';
    }

}