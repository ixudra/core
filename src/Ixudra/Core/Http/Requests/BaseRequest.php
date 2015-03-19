<?php namespace Ixudra\Core\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest {

    public function getInput()
    {
        return $this->input();
    }

}
