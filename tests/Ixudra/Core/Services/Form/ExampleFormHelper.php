<?php


use Ixudra\Core\Services\Form\BaseFormHelper;

class ExampleFormHelper extends BaseFormHelper {

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

}