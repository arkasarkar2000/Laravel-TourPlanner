<?php

namespace App\Exports;

use App\Models\Trips;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SearchTripExport implements FromCollection, WithHeadings
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

    public function collection()
    {
        $query = Trips::select('trip_to','total_fare','total_days','from','to','members');
        if (!empty($this->input_search)) {
            $query->where('trip_to', 'like', '%' . $this->input_search . '%')
                    ->orWhere('members', 'like', '%' . $this->input_search . '%')
                  ->orWhere('total_fare', 'like', '%' . $this->input_search . '%');
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
