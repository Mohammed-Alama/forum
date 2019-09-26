<?php


namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{

    /**
     * @var Request
     */
    protected $request ,$builder;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        collect($this->getFilters())
            ->filter(function ($filter){
                return method_exists($this,$filter);
            })
            ->each(function ($value,$filter){
                $this->$filter($value);
            });

        return $builder;
    }


    /**
     * @return array
     */
    protected function getFilters(): array
    {
        $filters = array_intersect(array_keys($this->request->all()), $this->filters);
        return $this->request->only($filters);
    }
}