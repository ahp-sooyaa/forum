<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;
    protected $builder;
    protected $filters = [];

    /**
    * ThreadFilter constructor
    * @param Illuminate\Http\Request $request
    */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilter() as $filter => $value) {
            if ($this->hasFilter($filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilter()
    {
        return array_filter($this->request->only($this->filters));
    }

    public function hasFilter($filter)
    {
        return method_exists($this, $filter) && $this->request->has($filter);
    }
}
