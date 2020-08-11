<?php


use PHPUnit\Framework\TestCase;

class BaseFactoryTest extends TestCase {

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

    /**
     * @covers \Ixudra\Core\Services\Factories\BaseFactory::preventXss()
     * @dataProvider preventXssDataProvider
     */
    public function testPreventXss($value, $result)
    {
        $baseFactoriesHelperMock = new ExampleFactory();

        $this->assertEquals( $result, $baseFactoriesHelperMock->getPreventedXssOutput( $value ) );
    }

    public function preventXssDataProvider()
    {
        return array(
            array( 'Foo', 'Foo' ),
            array( '<p>Foo</p>', '<p>Foo</p>' ),
            array( '<IMG SRC=JaVaScRiPt:alert(\'XSS\')>', '' ),
            array( '<IMG SRC=`javascript:alert("RSnake says, \'XSS\'")`>', '' ),
            array( '<IMG """><SCRIPT>alert("XSS")</SCRIPT>">', '' ),
            array( '<IMG SRC=&#x6A&#x61&#x76&#x61&#x73&#x63&#x72&#x69&#x70&#x74&#x3A&#x61&#x6C&#x65&#x72&#x74&#x28&#x27&#x58&#x53&#x5305&#x27&#x29>', '' ),
            array( '\';alert(String.fromCharCode(88,83,83))//\';alert(String.fromCharCode(88,83,83))//";', '' ),
            array( 'alert(String.fromCharCode(88,83,83))//";alert(String.fromCharCode(88,83,83))//--', '' ),
            array( '></SCRIPT>">\'><SCRIPT>alert(String.fromCharCode(88,83,83))</SCRIPT>', '' ),
        );
    }

}
