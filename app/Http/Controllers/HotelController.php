<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Pipelines\NameFilter;
use App\Pipelines\DestinationFilter;
use App\Pipelines\PriceRangeFilter;
use App\Pipelines\DateRangeFilter;
use Illuminate\Pipeline\Pipeline;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $hotels = $this->fetchHotels()['hotels'];

        $filteredHotels = app(Pipeline::class)
            ->send($hotels)
            ->through([
                NameFilter::class,
                DestinationFilter::class,
                PriceRangeFilter::class,
                DateRangeFilter::class,
            ])
            ->thenReturn();

        return response()->json($filteredHotels);
    }

    private function fetchHotels()
    {
        $response = Http::get('https://api.npoint.io/dd85ed11b9d8646c5709');
        return $response->json();
    }
}