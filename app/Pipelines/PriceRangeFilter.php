<?php
namespace App\Pipelines;

use Closure;

class PriceRangeFilter
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);
        // Filter by price range
        if (request()->has('price_range')) {
            $priceRange = request()->input('price_range');
            $prices = explode(':', $priceRange);
            if (count($prices) === 2) {

                $minPrice = intval($prices[0]);
                $maxPrice = intval($prices[1]);

                $data = array_filter($data, function ($hotel) use ($minPrice, $maxPrice) {
                  $price = intval($hotel['price']);
                    return $price >= $minPrice && $price <= $maxPrice;
                });

            }
        }

        return $data;
    }
}