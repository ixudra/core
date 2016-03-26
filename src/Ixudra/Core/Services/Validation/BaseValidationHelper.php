<?php namespace Ixudra\Core\Services\Validation;


abstract class BaseValidationHelper {

    /**
     * Return the validation rules that need to be applied to filter a specific model
     *
     * @return array
     */
    abstract public function getFilterValidationRules();

    /**
     * Return the validation rules that need to be applied to a specific model form
     *
     * @param   string $formName        Name of the form for which the rules will be used
     * @param   string $prefix          Prefix that is to be applied to the form rules
     * @return array
     */
    abstract public function getFormValidationRules($formName, $prefix = '');

    /**
     * Force a particular rule to be optional. This method will remove the 'required` option from the rule entirely and
     * leave all other validation rules intact
     *
     * @param   string $rule        Rule to be modified
     * @return string
     */
    public function makeOptional($rule)
    {
        $conditions = explode('|', $rule);
        foreach( $conditions as $key => $condition ) {
            if( $condition == 'required' ) {
                unset( $conditions[ $key ] );
            }
        }

        return implode( '|', $conditions );
    }

    /**
     * Return an array of all form rules that are required
     *
     * @param   string $formName        Name of the form for which the rules will be used
     * @param   string $prefix          Prefix that is to be applied to the form rules
     * @return array
     */
    public function getRequiredFormFields($formName, $prefix = '')
    {
        $rules = $this->getFormValidationRules( $formName, $prefix );

        $requiredFields = array();
        foreach( $rules as $key => $value ) {
            if( $this->isRequired( $value ) ) {
                $requiredFields[] = $key;
            }
        }

        return $requiredFields;
    }

    /**
     * Verify if a rule is required
     *
     * @param   string $rule        Rule to be verified
     * @return bool
     */
    protected function isRequired($rule)
    {
        $conditions = explode('|', $rule);
        if( in_array('required', $conditions) ) {
            return true;
        }

        return false;
    }

    /**
     * Return the validation rules that need to be applied to a specific model form
     *
     * @param   array $rules                Name of the form for which the rules will be used
     * @param   string $prefix              Prefix that is to be applied to the form rules
     * @param   boolean $forceOptional      Force all rules to be optional
     * @return array
     */
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