<?php

namespace ZestyBus\LaravelSimpleSearch;

use Illuminate\Database\Eloquent\Builder;
use ZestyBus\LaravelSimpleSearch\Exceptions\SimpleSearchException;
use ZestyBus\LaravelSimpleSearch\Search\Column;

trait SimpleSearch
{
    /**
     *  @param  \Illuminate\Database\Eloquent\Builder $query
     *  @param string $search
     *  @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSimpleSearch(Builder $query, string $search) : Builder
    {
        $columns = $this->getSimpleSearchColumns();

        if(! isset($columns)) {
            throw new SimpleSearchException('Must have a simple search property.');
        }

        if(! is_array($columns)) {
            throw new SimpleSearchException('Simple search property must be an array.');
        }

        $search = "%$search%";

        return $query->where(function($query) use($search, $columns) {
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

    /**
     *  @return array
     */
    protected function getSimpleSearchColumns() : array
    {
        return $this->searchable;
    }
}
