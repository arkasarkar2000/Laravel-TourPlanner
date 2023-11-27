<?php

namespace App\Exports;

use App\Models\Trips;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TripExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return [
            'Destination',
            'Total Fare',
            'Total Days',
            'From',
            'To',
            'Members'
        ];
    }

    public function collection()
    {
        $q = Trips::select('trip_to','total_fare','total_days','from','to','members');
        $trips = $q->get();
        $tripsArr = [];
        // dd($trips);
        foreach($trips as $trip){

            $tripsArr[] = [
                'trip_to' => $trip->trip_to,
                'total_fare' => $trip->total_fare,
                'total_days' => $trip->total_days,
                'from' => $trip->from,
                'to' => $trip->to,
                'members' => $trip->members
            ];
        }
        return new Collection($tripsArr);
    }
}
