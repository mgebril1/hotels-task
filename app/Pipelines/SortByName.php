<?php
namespace App\Pipelines;

use Closure;

class SortByName
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);

        // Sort by hotel name
        if (request()->has('sort_by') && request()->input('sort_by') === 'name') {
            $data = $data->sortBy('name');
        }

        return $data;
    }
}