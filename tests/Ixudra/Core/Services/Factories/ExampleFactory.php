<?php


use Ixudra\Core\Services\Factories\BaseFactory;

class ExampleFactory extends BaseFactory {

    public function getExtractedInput($input, $keys, $prefix = '', $includeDefault = false)
    {
        return $this->extractInput( $input, $keys, $prefix, $includeDefault );
    }

    public function getPreventedXssOutput($value)
    {
        return $this->preventXss( $value );
    }

}