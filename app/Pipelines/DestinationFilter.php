<?php
namespace App\Pipelines;

use Closure;

class DestinationFilter
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);

        // Filter by destination (city)
        if (request()->has('destination')) {
            
            $city = request()->input('destination');

            $data = array_filter($data, function ($hotel) use ($city) {
              return str_contains(strtolower($hotel['city']), strtolower($name));
            });
        }

        return $data;
    }
}