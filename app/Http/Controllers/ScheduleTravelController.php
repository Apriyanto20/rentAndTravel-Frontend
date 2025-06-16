<?php

namespace App\Http\Controllers;

use App\Models\DetailSeat;
use App\Models\SheduleTravel;
use App\Models\TransportationRoute;
use App\Models\TransportationsTravelDetail;
use Illuminate\Http\Request;

class ScheduleTravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->input('page', 1);
        $entries = request()->input('entries', 10);
        $search = request()->input('search');

        $query = SheduleTravel::query()
            ->join('transportation_route', 'schedule_travel.codeRoute', '=', 'transportation_route.codeRoute')
            ->join('transportations_travel_detail', 'schedule_travel.codeDetailTransportation', '=', 'transportations_travel_detail.codeDetailTransportation')
            ->join('drivers', 'transportations_travel_detail.driverCode', '=', 'drivers.nik');

        if ($search) {
            $query->where('merk.merk', 'like', '%' . $search . '%')
                ->orWhere('transportations.transportation', 'like', '%' . $search . '%');
        }

        $schedule = $query->paginate($entries);
        return view('scheduleTravel.index', compact(['schedule']))
            ->with('i', ($page - 1) * $entries);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $codeSchedule = SheduleTravel::codeSchedule();
        $route = TransportationRoute::all();
        $transportation = TransportationsTravelDetail::all();
        return view('scheduleTravel.create')->with([
            'codeSchedule' => $codeSchedule,
            'route' => $route,
            'transportation' => $transportation,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'codeSchedule' => $request->input('codeSchedule'),
            'hari' => $request->input('hari'),
            'codeRoute' => $request->input('codeRoute'),
            'codeDetailTransportation' => $request->input('codeDetailTransportation'),
        ];

        SheduleTravel::create($data);

        return redirect()
            ->route('schedule.index')
            ->with('message_insert', 'Data Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $codeSchedule = SheduleTravel::codeSchedule();
        $route = TransportationRoute::all();
        $transportation = TransportationsTravelDetail::all();

        $scheduleRoute = SheduleTravel::findOrFail($id);
        return view('scheduleTravel.edit')->with([
            'codeSchedule' => $codeSchedule,
            'route' => $route,
            'transportation' => $transportation,
            'scheduleRoute' => $scheduleRoute,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'hari' => $request->input('hari'),
            'codeRoute' => $request->input('codeRoute'),
            'codeDetailTransportation' => $request->input('codeDetailTransportation'),
        ];

        $datas = SheduleTravel::findOrFail($id);
        $datas->update($data);
        return redirect()
            ->route('schedule.index')
            ->with('message_update', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = SheduleTravel::findOrFail($id);
        $data->delete();
        return back()->with('message_delete', 'Data Berhasil dihapus');
    }
}
