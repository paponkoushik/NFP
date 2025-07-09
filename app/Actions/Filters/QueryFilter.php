<?php

namespace App\Actions\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    /**
     * The request instance.
     *
     * @var object
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var object
     */
    protected $builder;

    /**
     * Create a new query filter instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply all query filter method to the request.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return object
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            //dump(gettype($value) . ' val: ' . json_encode($value));
            //dump('name: ' . $name . ' value: ' . json_encode(array_filter([$value])));
            if (method_exists($this, $name)) {
                if (!empty($value)) {
                    call_user_func_array([$this, $name], [$value]);
                }
            }
        }

        return $this->builder;
    }

    /**
     * Get all query filter included in the request.
     *
     * @return array
     */
    public function filters()
    {
        return $this->request->all();
    }
}
