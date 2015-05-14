<?php


use Ixudra\Core\Presenters\BasePresenter;

class ExamplePresenter extends BasePresenter {

    protected $value;


    public function __construct($value)
    {
        $this->value = $value;
    }


    public function getTruthy()
    {
        return $this->truthy( $this->value );
    }

    public function getShortWithLength($length)
    {
        return $this->short( $this->value, $length );
    }

    public function getShortWithoutLength()
    {
        return $this->short( $this->value );
    }

}