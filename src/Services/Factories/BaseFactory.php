<?php namespace Ixudra\Core\Services\Factories;


abstract class BaseFactory {

    /**
     * Extract input data that is to be used to fill the model. This allows you to use one big input array and prevent
     * faulty data from entering your database.
     *
     * @param   array $input            Input values that can be used to fill the model
     * @param   array $keys             List of keys in the input array that should be extracted for filling the model
     * @param   string $prefix          Prefix that needs is used to identify the input values that need to be used to fill the model
     * @param   bool $includeDefaults   Used to indicate whether or not the missing values in the input array must be augmented with default values
     * @return array
     */
    protected function extractInput($input, $keys, $prefix = '', $includeDefaults = false)
    {
        if( $prefix !== '' ) {
            $prefix .= '_';
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

    /**
     * Remove potential XSS attacks from the input string
     *
     * @param   string $value       String value that needs to be cleaned of XSS data
     * @return string
     */
    protected function preventXss($value)
    {
        $string = strtolower( html_entity_decode( $value ) );

        if (strpos($string, '<script>') !== false) {
            $value = '';
        }

        if (strpos($string, 'javascript') !== false) {
            $value = '';
        }

        if (strpos($string, 'fromcharcode') !== false) {
            $value = '';
        }

        if (strpos($string, '&#x') !== false) {
            $value = '';
        }

        return $value;
    }

}