<?php namespace Ixudra\Core\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest {

    public function all()
    {
        return array_replace_recursive($this->getInput(), $this->files->all());
    }

    public function getInput()
    {
        return $this->input();
    }

    protected function convertToTruthyValue($input, $key)
    {
        $value = false;
        if( array_key_exists($key, $input) && $input[ $key ] != '' ) {
            $value = true;
        }

        return $value;
    }

}
