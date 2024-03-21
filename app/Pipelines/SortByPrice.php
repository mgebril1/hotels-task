<?php
namespace App\Pipelines;

use Closure;

class SortByPrice
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);

        // Sort by price
        if (request()->has('sort_by') && request()->input('sort_by') === 'price') {

            usort($data, function ($a, $b) {
                return $a['price'] <=> $b['price'];
            });

        }

        return $data;
    }
}