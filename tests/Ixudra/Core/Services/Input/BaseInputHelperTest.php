<?php


use PHPUnit\Framework\TestCase;

class BaseInputHelperTest extends TestCase {

    /**
     * @covers \Ixudra\Core\Services\Input\BaseInputHelper::getInputForModel()
     */
    public function testGetInputForModel_withoutPrefix()
    {
        $input = array(
            'Foo'               => 'Bar',
            'Foz'               => 'Baz',
            'Fov'               => 'Bav',
        );

        $expectedResult = array(
            'Foo'               => 'Bar',
            'Foz'               => 'Baz',
            'Fov'               => 'Bav',
        );

        $modelMock = Mockery::mock('stdClass');
        $modelMock->shouldReceive('attributesToArray')->once()->andReturn($input);

        $baseInputHelperMock = $this->getMockForAbstractClass('\Ixudra\Core\Services\Input\BaseInputHelper');

        $this->assertEquals( $expectedResult, $baseInputHelperMock->getInputForModel( $modelMock ) );
    }

    /**
     * @covers \Ixudra\Core\Services\Input\BaseInputHelper::getInputForModel()
     */
    public function testGetInputForModel_withPrefix()
    {
        $input = array(
            'Foo'               => 'Bar',
            'Foz'               => 'Baz',
            'Fov'               => 'Bav',
        );

        $expectedResult = array(
            'pre_Foo'           => 'Bar',
            'pre_Foz'           => 'Baz',
            'pre_Fov'           => 'Bav',
        );

        $modelMock = Mockery::mock('stdClass');
        $modelMock->shouldReceive('attributesToArray')->once()->andReturn($input);

        $baseInputHelperMock = $this->getMockForAbstractClass('\Ixudra\Core\Services\Input\BaseInputHelper');

        $this->assertEquals( $expectedResult, $baseInputHelperMock->getInputForModel( $modelMock, 'pre' ) );
    }

    /**
     * @covers \Ixudra\Core\Services\Input\BaseInputHelper::testGetInputForSearch()
     */
    public function testGetInputForSearch()
    {
        $input = array(
            '_token'            => 'Foo_token',
            'Foo'               => 'Bar'
        );

        $expectedResult = array(
            'Foo'               => 'Bar'
        );

        $baseInputHelperMock = $this->getMockForAbstractClass('\Ixudra\Core\Services\Input\BaseInputHelper');

        $this->assertEquals( $expectedResult, $baseInputHelperMock->getInputForSearch( $input ) );
    }

}
