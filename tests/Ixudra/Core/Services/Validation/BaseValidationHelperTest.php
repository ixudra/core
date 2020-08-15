<?php


use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class BaseValidationHelperTest extends TestCase {

    /**
     * @covers \Ixudra\Core\Services\Validation\BaseValidationHelper::getRequiredFormFields()
     * @covers \Ixudra\Core\Services\Validation\BaseValidationHelper::isRequired()
     */
    public function testGetRequiredFormFields()
    {
        $expectedResult = array(
            'Foo_name',
            'Bar_name',
            'Bav_name',
        );

        $baseValidationHelperMock = new ExampleValidationHelper();

        $this->assertEquals( $expectedResult, $baseValidationHelperMock->getRequiredFormFields( 'Foo' ) );
    }

    /**
     * @covers \Ixudra\Core\Services\Validation\BaseValidationHelper::makeOptional()
     *
     * @dataProvider makeOptionalDataProvider
     */
    public function testMakeOptional($rule, $expected)
    {
        $baseValidationHelperMock = new ExampleValidationHelper();

        $this->assertEquals( $expected, $baseValidationHelperMock->makeOptional( $rule ) );
    }

    public function makeOptionalDataProvider()
    {
        return array(
            array( 'required|max:60', 'max:60' ),
            array( 'email|required', 'email' ),
            array( 'required_with|max:60', 'required_with|max:60' ),
            array( 'required_if|max:60', 'required_if|max:60' ),
            array( 'required_without|max:60', 'required_without|max:60' ),
            array( 'email|required|max:60', 'email|max:60' ),
        );
    }

    /**
     * @covers \Ixudra\Core\Services\Validation\BaseValidationHelper::getPrefixedRules()
     */
    public function testGetPrefixedRules()
    {
        $input = array(
            'Foo_name'              => 'required|max:60',
            'Bar_name'              => 'email|max:60',
        );

        $expectedResult = array(
            'pre_Foo_name'          => 'required|max:60',
            'pre_Bar_name'          => 'email|max:60',
        );

        $baseValidationHelperMock = new ExampleValidationHelper();

        $this->assertEquals( $expectedResult, $baseValidationHelperMock->prefixedRules( $input, 'pre', false ) );
    }

    /**
     * @covers \Ixudra\Core\Services\Validation\BaseValidationHelper::getPrefixedRules()
     * @covers \Ixudra\Core\Services\Validation\BaseValidationHelper::makeOptional()
     */
    public function testGetPrefixedRules_foreOptional()
    {
        $input = array(
            'Foo_name'              => 'required|max:60',
            'Bar_name'              => 'email|max:60',
        );

        $expectedResult = array(
            'pre_Foo_name'          => 'max:60',
            'pre_Bar_name'          => 'email|max:60',
        );

        $baseValidationHelperMock = new ExampleValidationHelper();

        $this->assertEquals( $expectedResult, $baseValidationHelperMock->prefixedRules( $input, 'pre', true ) );
    }

}
