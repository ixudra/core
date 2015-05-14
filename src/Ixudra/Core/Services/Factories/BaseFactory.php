<?php namespace Ixudra\Core\Services\Factories;


abstract class BaseFactory {

    protected function extractInput($input, $keys, $prefix = '', $includeDefaults = false)
    {
        if( $prefix != '' ) {
            $prefix = $prefix .'_';
        }

        $results = array();
        foreach( $keys as $key => $value ) {
            if( !array_key_exists( $prefix . $key, $input) && !$includeDefaults ) {
                continue;
            }

            if( array_key_exists( $prefix . $key, $input) ) {
                $results[ $key ] = $input[ $prefix . $key ];
                continue;
            }

            if( $includeDefaults ) {
                $results[ $key ] = $value;
            }
        }

        return $results;
    }

}