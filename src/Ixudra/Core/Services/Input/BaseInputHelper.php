<?php namespace Ixudra\Core\Services\Input;


abstract class BaseInputHelper {

    abstract public function getDefaultInput($prefix = '');

    public function getInputForModel($model, $prefix = '')
    {
        return $this->getPrefixedInput( $model->attributesToArray(), $prefix );
    }

    protected function getPrefixedInput($input, $prefix = '')
    {
        if( $prefix == '' ) {
            return $input;
        }

        $results = '';
        foreach( $input as $key => $value ) {
            $results[ $prefix .'_'. $key ] = $value;
        }

        return $results;
    }

    public function getInputForSearch($input)
    {
        if( array_key_exists('_token', $input) ) {
            unset( $input[ '_token' ] );
        }

        return $input;
    }

}