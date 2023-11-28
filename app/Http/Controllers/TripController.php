<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Validation\Rules\Password;
use App\Exports\TripExport;
use App\Exports\SearchTripExport;
use App\Models\Trips;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Pagination\Paginator;

class TripController extends Controller
{
    public function create_trip(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'days' => 'required|string|max:255',
            'fare' => 'required|integer',
            'from' => 'required|date',
            'to' => 'required|date',
            'members' => 'required|array',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/home')->withErrors($validator)->withInput();
        }

        $membersString = implode(',', $request->input('members', []));
        $data = Trips::create([
            'trip_to' => $request->name,
            'total_days' => $request->days,
            'total_fare' => $request->fare,
            'from' => $request->from,
            'to' => $request->to,
            'members' => $membersString,
        ]);
        return redirect('/home');
    }

    public function list_trip(Request $request)
    {
        $query = Trips::orderBy('created_at', 'asc');
        $users = DB::table('users')->select('name')->get();
        $roles = DB::table('roles')->select('role_name')->get();

        if (!empty($request->input_search)) {
            $query->where('trip_to', 'like', '%' . $request->input_search . '%')
                    ->orWhere('members', 'like', '%' . $request->input_search . '%')
                  ->orWhere('total_fare', 'like', '%' . $request->input_search . '%');
        }
        $trips = $query->paginate(5);
        return view('home', compact('trips', 'users','roles','request'));
    }

    public function edit($id)
    {
        $trip = Trips::find($id);
        $users = DB::table('users')->select('name')->get();
        return view('edit_trip', compact('trip','users'));
    }

    public function update(Request $request, $id)
    {
        $trip = Trips::find($id);

        $membersString = implode(',', $request->input('members', []));
        $trip->update([
            'trip_to' => $request->input('name'),
            'total_days' => $request->input('days'),
            'total_fare' => $request->input('fare'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'members' => $membersString,
        ]);
        return redirect('/home');
    }

    public function destroy($id)
    {
        $trips = Trips::find($id);
        $trips->delete();
        return redirect('/home');
    }

    public function get_trips_data(Request $request)
    {
        // dd($request->input_search);
        if(isset($request->input_search)){
            return Excel::download(new SearchTripExport($request->input_search), 'trips_filtered.xlsx');
        }
        return Excel::download(new TripExport, 'trips.xlsx');
    }
}
