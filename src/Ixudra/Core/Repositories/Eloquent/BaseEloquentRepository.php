<?php namespace Ixudra\Core\Repositories\Eloquent;


abstract class BaseEloquentRepository {

    public function all()
    {
        return $this->getModel()->all();
    }

    public function find($id)
    {
        return $this->getModel()->find($id);
    }

    public function findByFilter($filters)
    {
        $results = $this->getModel();
        $results = $this->applyFilters( $results, $filters );

        return $results->get();
    }

    public function search($filters, $resultsPerPage = 25)
    {
        $results = $this->getModel();

        return $results
            ->select($this->getTable() .'.*')
            ->paginate($resultsPerPage)
            ->appends($filters)
            ->appends('size', $resultsPerPage);
    }

    abstract protected function getModel();

    abstract protected function getTable();

    protected function applyFilters($query, $filters = array())
    {
        foreach( $this->preProcessFilters($filters) as $key => $value ) {
            if( $value == '' ) {
                continue;
            }

            $query = $query->where($key, '=', $value);
        }

        return $query;
    }

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

    protected function hasKey($filters, $key)
    {
        return ( array_key_exists($key, $filters) && $filters[ $key ] != 0 && $filters[ $key ] != '' );
    }

    protected function hasString($filters, $key)
    {
        return ( array_key_exists($key, $filters) && $filters[ $key ] != '' );
    }

    protected function hasBoolean($filters, $key)
    {
        return ( array_key_exists($key, $filters) && $filters[ $key ] != '' );
    }

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
