<?php namespace Ixudra\Core\Repositories\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class BaseEloquentRepository {

    /**
     * Return all instances of the repository model
     *
     * @return  Collection
     */
    public function all()
    {
        return $this->getModel()->all();
    }

    /**
     * Return a single instance of the repository model by id
     *
     * @param   integer $id
     * @return  Model
     */
    public function find($id)
    {
        return $this->getModel()->find($id);
    }

    /**
     * Find all instances of the repository model that match a particular filter
     *
     * @param   array $filters      The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @return  Collection
     */
    public function findByFilter($filters)
    {
        $results = $this->getModel();
        $results = $this->applyFilters( $results, $filters );

        return $results->get();
    }

    /**
     * Find all instances of the repository model that match a particular filter
     *
     * @param   array $filters      The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @param   int $size           The amount of results that we expect to receive from the paginator
     * @return  Collection
     */
    public function search($filters, $size = 25)
    {
        $results = $this->getModel();

        return $this->paginated($results, $filters, $size);
    }

    /**
     * Return the paginated result of the query
     *
     * @param   Builder $results    The query builder that contains all the clauses that have been applied
     * @param   array $filters      The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @param   int $size           The amount of results that we expect to receive from the paginator
     * @return mixed
     */
    protected function paginated($results, $filters = array(), $size = 25)
    {
        return $results
            ->select($this->getTable() .'.*')
            ->paginate($size)
            ->appends($filters)
            ->appends('size', $size);
    }

    /**
     * Return a new instance of the repository model
     *
     * @return Model
     */
    abstract protected function getModel();

    /**
     * Return the name of the repository table
     *
     * @return Model
     */
    abstract protected function getTable();

    /**
     * Apply various filters to the query builder. All filters must be applied using the '=' operator. Filters that
     * require other operators or additional operations such as joins, must be applied in a different way
     *
     * @param   Builder $query          The query builder that contains all the clauses that have been applied
     * @param   array $filters          The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @param   array $excludeFilters   The filters that are to be ignored. This might be useful if the filters require a join before they can be applied or if they require a different operator
     * @return mixed
     */
    protected function applyFilters($query, $filters = array(), $excludeFilters = array())
    {
        foreach( $this->preProcessFilters($filters) as $key => $value ) {
            if( $value == '' || in_array( $key, $excludeFilters ) ) {
                continue;
            }

            $query = $query->where($key, '=', $value);
        }

        return $query;
    }

    /**
     * Apply various foreign key filters to the query builder. All filters must be applied using the '=' operator.
     * Filters that require other operators or additional operations such as joins, must be applied in a different way
     *
     * @param   Builder $query          The query builder that contains all the clauses that have been applied
     * @param   array $foreignKeys      The list of keys that are identified as foreign keys
     * @param   array $filters          The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @return mixed
     */
    protected function applyForeignKeys($query, $foreignKeys, $filters = array())
    {
        foreach( $foreignKeys as $key ) {
            if( !$this->hasKey( $filters, $key ) ) {
                continue;
            }

            $query = $query->where($key, '=', $filters[ $key ]);
        }

        return $query;
    }

    /**
     * Apply various boolean key filters to the query builder. All filters must be applied using the '=' operator.
     * Filters that require other operators or additional operations such as joins, must be applied in a different way
     *
     * @param   Builder $query          The query builder that contains all the clauses that have been applied
     * @param   array $booleanKeys      The list of keys that are identified as boolean keys
     * @param   array $filters          The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @return mixed
     */
    protected function applyBoolean($query, $booleanKeys, $filters = array())
    {
        foreach( $booleanKeys as $key ) {
            if( !$this->hasBoolean( $filters, $key ) ) {
                continue;
            }

            $query = $query->where($key, '=', $filters[ $key ]);
        }

        return $query;
    }

    /**
     * Verify if a specific filter key can be used as a filter value
     *
     * @param   array $filters          The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @param   string $key             The filter key that must be verified
     * @return boolean
     */
    protected function hasKey($filters, $key)
    {
        return ( array_key_exists($key, $filters) && $filters[ $key ] != 0 && $filters[ $key ] != '' );
    }

    /**
     * Verify if a specific filter key can be used as a string filter
     *
     * @param   array $filters          The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @param   string $key             The filter key that must be verified
     * @return boolean
     */
    protected function hasString($filters, $key)
    {
        return ( array_key_exists($key, $filters) && $filters[ $key ] != '' );
    }

    /**
     * Verify if a specific filter key can be used as a boolean filter
     *
     * @param   array $filters          The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @param   string $key             The filter key that must be verified
     * @return boolean
     */
    protected function hasBoolean($filters, $key)
    {
        return ( array_key_exists($key, $filters) && $filters[ $key ] != '' );
    }

    /**
     * Pre process the filters before applying them to the query builder. By default it will only convert boolean
     * values to integer values
     *
     * @param   array $filters          The filters that are to be applied to the query. The key identifies the database column, the value in the array is the value that is to be matched in the query
     * @return mixed
     */
    protected function preProcessFilters($filters)
    {
        foreach( $filters as $key => $value ) {
            if( $value === true ) {
                $filters[ $key ] = '1';
                continue;
            }

            if( $value === false ) {
                $filters[ $key ] = '0';
                continue;
            }
        }

        return $filters;
    }

}
