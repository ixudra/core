<?php


use Ixudra\Core\Services\Validation\BaseValidationHelper;

class ExampleValidationHelper extends BaseValidationHelper {

    public function getFilterValidationRules()
    {
        // ...
    }

    public function getFormValidationRules($formName, $prefix = '')
    {
        return array(
            'Foo_name'              => 'required|max:60',
            'Bar_name'              => 'email|required',
            'Foz_name'              => 'required_with|max:60',
            'Baz_name'              => 'required_if|max:60',
            'Fov_name'              => 'required_without|max:60',
            'Bav_name'              => 'email|required|max:60',
        );
    }

    public function prefixedRules($rules, $prefix, $forceOptional)
    {
        return $this->getPrefixedRules( $rules, $prefix, $forceOptional );
    }

}
