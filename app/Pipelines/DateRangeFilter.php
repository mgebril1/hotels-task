<?php
namespace App\Pipelines;

use Closure;

class DateRangeFilter
{
    public function handle($request, Closure $next)
    {
        $data = $next($request);
        
        $dateRange = $this->getRequestDateRange();
        if($dateRange == false)
        {
            return $data;
        }
        // Filter by date range
        $data = array_filter($data, function ($hotel) use ($dateRange) {
            $vailableOrNot = array_filter($hotel['availability'],function($vailable) use($dateRange){
                $from = strtotime($vailable['from']);
                $to = strtotime($vailable['to']);
                if (($dateRange['startDate'] >= $from && $dateRange['startDate'] <= $to) || ($dateRange['endDate'] >= $from && $dateRange['endDate'] <= $to)) {
                    return true;
                }
                return false;
            });
            return $vailableOrNot;
        });


        return $data;
    }


    private function getRequestDateRange()
    {
        if (request('date_range')) {
    
            $dateRange = request('date_range');
            $dates = explode(':', $dateRange);

            if (count($dates) === 2) {

                $startDate = strtotime($dates[0]);
                $endDate = strtotime($dates[1]);
                return ['startDate'=>$startDate,'endDate'=>$endDate];
            }
        }
        return false;
    }
}