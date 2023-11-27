<?php

namespace App\Exports;

use App\Models\Trips;
use Maatwebsite\Excel\Concerns\FromCollection;

class SearchTripExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($input_search)
    {
        $this->input_search = $input_search;
    }
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


    public function collection(Request $request)
    {
        dd($request);
        if (!empty($request->input_search)) {
            $query->where('trip_to', 'like', '%' . $request->input_search . '%')
                    ->orWhere('members', 'like', '%' . $request->input_search . '%')
                  ->orWhere('total_fare', 'like', '%' . $request->input_search . '%');
        }

        $trips = $query->get();
        $tripsArr = [];
        foreach ($trips as $trip) {
            $tripsArr[] = [
                'trip_to' => $trip->trip_to,
                'total_fare' => $trip->total_fare,
                'members' => $trip->members
            ];
        };
        return new Collection ($tripsArr);
    }
}
