<?php namespace Ixudra\Core\Services\Factories;


abstract class BaseFactory {

    protected function extractInput($input, $keys, $prefix = '')
    {
        if( $prefix != '' ) {
            $prefix = $prefix .'_';
        }

        $results = array();
        foreach( $keys as $key => $value ) {
            if( array_key_exists( $prefix . $key, $input) ) {
                $results[ $key ] = $input[ $prefix . $key ];
            }

            $results[ $key ] = $input[ $prefix . $key ];
        }

        return $results;
    }

}