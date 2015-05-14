<?php


use Illuminate\Support\Collection;

class BaseFormHelperTest extends PHPUnit_Framework_TestCase {

    const MODEL_ID_1 = 11;

    const MODEL_ID_2 = 12;


    /**
     * @covers \Ixudra\Core\Services\Form\BaseFormHelper::getAllAsSelectList()
     * @covers \Ixudra\Core\Services\Form\BaseFormHelper::convertToSelectList()
     */
    public function testGetAllAsSelectList()
    {
        $expectedResult = array(
            self::MODEL_ID_1        => 'Foo_name',
            self::MODEL_ID_2        => 'Bar_name',
        );

        $modelMock = Mockery::mock('stdClass');
        $modelMock->shouldReceive('all')->once()->andReturn( $this->prepareModels() );

        $baseFormHelperMock = new ExampleFormHelper( $modelMock );

        $this->assertEquals( $expectedResult, $baseFormHelperMock->getAllAsSelectList() );
    }

    /**
     * @covers \Ixudra\Core\Services\Form\BaseFormHelper::getAllAsSelectList()
     * @covers \Ixudra\Core\Services\Form\BaseFormHelper::convertToSelectList()
     */
    public function testGetAllAsSelectList_includesNullValueIfSpecified()
    {
        $expectedResult = array(
            0                       => '',
            self::MODEL_ID_1        => 'Foo_name',
            self::MODEL_ID_2        => 'Bar_name',
        );

        $modelMock = Mockery::mock('stdClass');
        $modelMock->shouldReceive('all')->once()->andReturn( $this->prepareModels() );

        $baseFormHelperMock = new ExampleFormHelper( $modelMock );

        $this->assertEquals( $expectedResult, $baseFormHelperMock->getAllAsSelectList( true ) );
    }

    /**
     * @covers \Ixudra\Core\Services\Form\BaseFormHelper::getSuggestionsForAutoComplete()
     * @covers \Ixudra\Core\Services\Form\BaseFormHelper::convertToAutoComplete()
     */
    public function testGetSuggestionsForAutoComplete()
    {
        $expectedResult = array(
            array(
                'data'          => self::MODEL_ID_1,
                'value'         => 'Foo_name'
            ),
            array(
                'data'          => self::MODEL_ID_2,
                'value'         => 'Bar_name'
            ),
        );

        $modelMock = Mockery::mock('stdClass');
        $modelMock->shouldReceive('findByFilter')->once()->with( array( 'name' => 'Foo_query' ) )->andReturn( $this->prepareModels() );

        $baseFormHelperMock = new ExampleFormHelper( $modelMock );

        $this->assertEquals( $expectedResult, $baseFormHelperMock->getSuggestionsForAutoComplete( 'Foo_query' ) );
    }

    protected function prepareModels()
    {
        $model1 = new stdClass();
        $model1->id = self::MODEL_ID_1;
        $model1->name = 'Foo_name';

        $model2 = new stdClass();
        $model2->id = self::MODEL_ID_2;
        $model2->name = 'Bar_name';

        $entries = new Collection( array( $model1, $model2 ) );

        return $entries;
    }

}