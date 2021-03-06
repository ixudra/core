<?php


use PHPUnit\Framework\TestCase;

class BasePresenterTest extends TestCase {

    /**
     * @covers \Ixudra\Core\Presenters\BasePresenter::short()
     */
    public function testShort_predefinedLength()
    {
        $message = 'Foooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo';
        $examplePresenter = new ExamplePresenter( $message );

        $this->assertEquals( 'Fooooooooooooooooooooooooooooooooooooooooooooooooo...', $examplePresenter->getShortWithLength( 50 ) );
    }

    /**
     * @covers \Ixudra\Core\Presenters\BasePresenter::short()
     */
    public function testShort_defaultLength()
    {
        $message = 'Fooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo';
        $examplePresenter = new ExamplePresenter( $message );

        $this->assertEquals( 'Fooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo...', $examplePresenter->getShortWithoutLength() );
    }

}
