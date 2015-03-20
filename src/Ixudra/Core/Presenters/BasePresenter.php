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

}