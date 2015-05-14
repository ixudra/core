<?php


class BaseFactoryTest extends PHPUnit_Framework_TestCase {

    /**
     * @covers \Ixudra\Core\Services\Factories\BaseFactory::extractInput()
     */
    public function testExtractInput()
    {
        $input = array(
            'pre_Foo'               => 'Bar',
            'pre_Foz'               => 'Baz',
        );

        $keys = array(
            'Foo'                   => 'Foo_value',
            'Foz'                   => 'Foz_value',
            'Fov'                   => 'Fov_value',
        );

        $expectedResult = array(
            'Foo'                   => 'Bar',
            'Foz'                   => 'Baz',
        );

        $baseFactoriesHelperMock = new ExampleFactory();

        $this->assertEquals( $expectedResult, $baseFactoriesHelperMock->getExtractedInput( $input, $keys, 'pre', false) );
    }

    /**
     * @covers \Ixudra\Core\Services\Factories\BaseFactory::extractInput()
     */
    public function testExtractInput_includeDefaults()
    {
        $input = array(
            'pre_Foo'               => 'Bar',
            'pre_Foz'               => 'Baz',
        );

        $keys = array(
            'Foo'                   => 'Foo_value',
            'Foz'                   => 'Foz_value',
            'Fov'                   => 'Fov_value',
        );

        $expectedResult = array(
            'Foo'                   => 'Bar',
            'Foz'                   => 'Baz',
            'Fov'                   => 'Fov_value',
        );

        $baseFactoriesHelperMock = new ExampleFactory();

        $this->assertEquals( $expectedResult, $baseFactoriesHelperMock->getExtractedInput( $input, $keys, 'pre', true) );
    }

}