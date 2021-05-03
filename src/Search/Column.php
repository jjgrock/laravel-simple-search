<?php

namespace ZestyBus\LaravelSimpleSearch\Search;

use Illuminate\Support\Str;

class Column
{
    public $name;
    public $relationship = null;

    /**
     *  @param string $column
     */
    public function __construct(string $name)
    {
        $this->name = $name;

        if($this->hasRelationship()) {
            $this->getRelationship();
        }
    }

    /**
     *  @return bool
     */
    public function hasRelationship() : bool
    {
        return isset($this->relationship) ? true : Str::contains($this->name, '.');
    }

    /**
     *  @return void
     */
    protected function getRelationship() : void
    {
        $pieces = explode('.', $this->name);

        $this->name = end($pieces);

        array_pop($pieces);

        $this->relationship = implode('.', $pieces);
    }
}
