<?php namespace Ixudra\Core\Services\Form;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Ixudra\Core\Repositories\Eloquent\BaseEloquentRepository;
use Translate;

abstract class BaseFormHelper {

    /** @var BaseEloquentRepository */
    protected $repository;

    /**
     * Return all models in the repository as a select list
     *
     * @param   bool $includeNull
     * @return array
     */
    public function getAllAsSelectList($includeNull = false)
    {
        $models = $this->repository->all();

        return $this->convertToSelectList($includeNull, $models);
    }

    /**
     * Get all models that match a particular query string as an auto complete list
     *
     * @param   string $query   Query string that is used to filter the results
     * @return array
     */
    public function getSuggestionsForAutoComplete($query)
    {
        $models = $this->repository->findByFilter( array( 'name' => $query ) );

        return $this->convertToAutoComplete( $models );
    }

    /**
     * Convert the selected models for a select list
     *
     * @param Collection $models
     * @return array
     */
    protected function convertToSelectList($includeNull, $models)
    {
        $results = array();
        if( $includeNull ) {
            $results[ 0 ] = '';
        }

        foreach( $models as $model ) {
            $results[ $model->id ] = $this->getName( $model );
        }

        return $results;
    }

    /**
     * Convert the selected models for an auto complete list
     *
     * @param Collection $models
     * @return array
     */
    protected function convertToAutoComplete($models)
    {
        $results = array();
        foreach( $models as $model ) {
            $results[] = array(
                'data'          => $model->id,
                'value'         => $this->getName( $model )
            );
        }

        return $results;
    }

    /**
     * Return the model data that can be used to identify the model in the select box
     *
     * @param   Model $model        Model that needs to be identified
     * @return mixed
     */
    protected function getName($model)
    {
        return $model->name;
    }

    /**
     * Return a yes-no select list
     *
     * @param   bool $includeNull   Indicate whether or not a null value is to be included in the result list
     * @return array
     */
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