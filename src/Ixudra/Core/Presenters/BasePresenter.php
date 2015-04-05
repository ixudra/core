<?php namespace Ixudra\Core\Presenters;


use Translate;

use Laracasts\Presenter\Presenter;

class BasePresenter extends Presenter {

    protected function truthy($value)
    {
        $key = 'no';
        if( $value ) {
            $key = 'yes';
        }

        return Translate::recursive('common.'. $key);
    }

    protected function short($string, $length = 200)
    {
        if( strlen( $string ) < $length ) {
            return $string;
        }

        return substr( $string, 0, $length ) .'...';
    }

}