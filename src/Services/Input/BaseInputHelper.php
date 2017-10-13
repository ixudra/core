<?php namespace Ixudra\Core\Services\Input;


use Illuminate\Database\Eloquent\Model;

abstract class BaseInputHelper {

    protected $immutableAttributes = array(
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    );


    /**
     * Return the default input values for a particular form or model
     *
     * @param   string $prefix      The prefix that needs to be added to the input
     * @return mixed
     */
    abstract public function getDefaultInput($prefix = '');

    /**
     * Return the attributes for a particular model as an array of input values
     *
     * @param   Model $model        The model for which we would like to return the input values
     * @param   string $prefix      The prefix that needs to be added to the input
     * @return array
     */
    public function getInputForModel($model, $prefix = '')
    {
        return $this->getPrefixedInput( $model->attributesToArray(), $prefix );
    }

    /**
     * Add a prefix to the input array
     *
     * @param   array $input        The input array that needs to be prefixed
     * @param   string $prefix      The prefix that needs to be added to the input
     * @return array
     */
    protected function getPrefixedInput($input, $prefix = '')
    {
        if( $prefix == '' ) {
            return $input;
        }

        $results = array();
        foreach( $input as $key => $value ) {
            $results[ $prefix .'_'. $key ] = $value;
        }

        return $results;
    }

    /**
     * Return all relevant attributes for a given model
     *
     * @param   Model $model        The model for which we would like to return the attributes
     * @return array
     */
    protected function getAttributes($model)
    {
        $attributes = $model->attributesToArray();
        foreach( $this->immutableAttributes as $attribute ) {
            unset( $attributes[ $attribute] );
        }

        return $attributes;
    }

    /**
     * Pre process the input array for searching the database
     *
     * @param   array $input
     * @return array
     */
    public function getInputForSearch($input)
    {
        if( array_key_exists('_token', $input) ) {
            unset( $input[ '_token' ] );
        }

        return $input;
    }

}