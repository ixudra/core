<?php namespace Ixudra\Core\Services\Factories;


abstract class BaseFactory {

    protected function extractInput($input, $keys, $prefix = '')
    {
        if( $prefix != '' ) {
            $prefix = $prefix .'_';
        }

        $results = array();
        foreach( $keys as $key => $value ) {
            $results[ $key ] = $input[ $prefix . $key ];
        }

        return $results;
    }

}