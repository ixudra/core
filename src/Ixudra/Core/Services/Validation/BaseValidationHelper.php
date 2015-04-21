<?php namespace Ixudra\Core\Services\Validation;


abstract class BaseValidationHelper {

    abstract public function getFilterValidationRules();

    abstract public function getFormValidationRules($formName);

    public function makeOptional($rule)
    {
        $rule = str_replace('required|', '', $rule);
        $rule = str_replace('|required', '', $rule);
        $rule = str_replace('required', '', $rule);

        return $rule;
    }

    public function getRequiredFormFields($formName)
    {
        $rules = $this->getFormValidationRules( $formName );

        $requiredFields = array();
        foreach( $rules as $key => $value ) {
            if( $this->isRequired( $value ) ) {
                $requiredFields[] = $key;
            }
        }

        return $requiredFields;
    }

    protected function isRequired($rule)
    {
        $conditions = explode('|', $rule);
        if( in_array('required', $conditions) ) {
            return true;
        }

        return false;
    }

    protected function getPrefixedRules($rules, $prefix = '', $forceOptional = false)
    {
        if( $prefix == '' ) {
            return $rules;
        }

        $results = '';
        foreach( $rules as $key => $value ) {
            if( $forceOptional ) {
                $value = $this->makeOptional( $value );
            }

            $results[ $prefix .'_'. $key ] = $value;
        }

        return $results;
    }

}