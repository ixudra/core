<?php namespace Ixudra\Core\Services\Form;


use Translate;

abstract class BaseFormHelper {

    protected $repository;


    public function getAllAsSelectList($includeNull = false)
    {
        $models = $this->repository->all();

        return $this->convertToSelectList($includeNull, $models);
    }

    public function getSuggestionsForAutoComplete($query)
    {
        $models = $this->repository->findByFilter( array( 'name' => $query ) );

        return $this->convertToAutoComplete( $models );
    }

    protected function convertToSelectList($includeNull, $models)
    {
        $results = array();
        if( $includeNull ) {
            $results[ 0 ] = '';
        }

        foreach( $models as $model ) {
            $results[ $model->id ] = $model->name;
        }

        return $results;
    }

    protected function convertToAutoComplete($models)
    {
        $results = array();
        foreach( $models as $model ) {
            $results[] = array(
                'data'          => $model->id,
                'value'         => $model->name
            );
        }

        return $results;
    }

    protected function getBooleanSelectList($includeNull = false)
    {
        $results = array();
        if( $includeNull ) {
            $results[ '' ] = Translate::recursive('common.both');
        }

        $results[ 0 ] = Translate::recursive('common.no');
        $results[ 1 ] = Translate::recursive('common.yes');

        return $results;
    }

}