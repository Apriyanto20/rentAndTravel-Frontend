<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use App\Models\TransportationsRentalDetail;
use Illuminate\Http\Request;

class TransportationRentalMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TransportationsRentalDetail::query();
        $merk = Merk::all();
        if ($request->has('codeMerk') && $request->codeMerk != '') {
            $query->where('codeMerk', $request->codeMerk);
        }
        if ($request->has('vehicle_statuses') && $request->vehicle_statuses != '') {
            $query->where('vehicle_statuses', $request->vehicle_statuses);
        }
        if ($request->has('search')) {
            $query->where('model', 'like', '%' . $request->search . '%');
        }
        $data = $query->get();
        return view('transportationsRental.member')->with([
            'data' => $data,
            'merk' => $merk,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
