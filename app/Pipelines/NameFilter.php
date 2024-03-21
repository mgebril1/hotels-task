<?php
namespace App\Pipelines;

use Closure;

class NameFilter
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);

        if (request()->has('name')) {
            $name = request()->input('name');

            $data = array_filter($data, function ($hotel) use ($name) {
              return str_contains(strtolower($hotel['name']), strtolower($name));
            });
        }

        return $data;
    }
}