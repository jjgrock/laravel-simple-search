<?php

namespace ZestyBus\LaravelSimpleSearch\Search;

use Countable;
use Illuminate\Database\Eloquent\Builder;

class Query
{
    /**
     *  @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     *  @param \Illuminate\Database\Eloquent\Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    protected function getColumns()
    {
        $property = config('laravel-simple-search.property');
        $columns = $this->builder->newModelInstance()->$property;

        return isset($columns) && is_array($columns) ? $columns : [];
    }

    /**
     *  @param string $string
     *  @param array $columns
     *  @return \Illuminate\Database\Eloquent\Builder
     */
    public function where(string $string = '', $columns = null)
    {
        $columns = $columns ?? $this->getColumns();

        $search = "%$string%";

        return $this->builder->where(function($query) use($search, $columns) {
            foreach($columns as $column) {

                $column = new Column($column);

                if($column->hasRelationship($column)) {
                    $query->orWhereHas($column->relationship, function($query) use($column, $search) {
                        $query->where($column->name, 'LIKE', $search);
                    });
                    continue;
                }

                $query->orWhere($column->name, 'LIKE', $search);
            }
        });
    }
}
