<?php

namespace App\Http\Controllers;

use App\Models\DetailSeat;
use App\Models\Drivers;
use App\Models\Merk;
use App\Models\TransactionsTravel;
use App\Models\TransportationsTravelDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportationsTravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->input('page', 1);
        $entries = request()->input('entries', 10);
        $search = request()->input('search');

        $query = TransportationsTravelDetail::query()
            ->join('merk', 'transportations_travel_detail.codeMerk', '=', 'merk.codeMerk')
            ->join('transportations', 'transportations_travel_detail.codeTransportation', '=', 'transportations.codeTransportation');

        if ($search) {
            $query->where('merk.merk', 'like', '%' . $search . '%')
                ->orWhere('transportations.transportation', 'like', '%' . $search . '%');
        }

        $transportationDetailTravel = $query->paginate($entries);

        return view('transportationsTravel.index', compact(['transportationDetailTravel']))
            ->with('i', ($page - 1) * $entries);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $codeTravel = TransportationsTravelDetail::codeTravel();
        $merk = Merk::all();
        $driver = Drivers::whereIn('status', ['ACTIVE', 'AKTIF'])->get();
        return view('transportationsTravel.create')->with([
            'codeTravel' => $codeTravel,
            'merk' => $merk,
            'driver' => $driver,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kode = $request->input('codeDetailTransportation');

        // Proses upload foto kendaraan
        if ($request->hasFile('photo_front')) {
            $photoFront = $request->file('photo_front');
            $photoFrontFileName = $kode . '-front.' . $photoFront->extension();
            $photoFront->move(public_path('travel'), $photoFrontFileName);
            $photoFrontFilePath = 'travel/' . $photoFrontFileName;
        } else {
            return redirect()->back()->with('error', 'Foto depan kendaraan tidak ditemukan');
        }

        if ($request->hasFile('photo_right')) {
            $photoRight = $request->file('photo_right');
            $photoRightFileName = $kode . '-right.' . $photoRight->extension();
            $photoRight->move(public_path('travel'), $photoRightFileName);
            $photoRightFilePath = 'travel/' . $photoRightFileName;
        } else {
            return redirect()->back()->with('error', 'Foto kanan kendaraan tidak ditemukan');
        }

        if ($request->hasFile('photo_left')) {
            $photoLeft = $request->file('photo_left');
            $photoLeftFileName = $kode . '-left.' . $photoLeft->extension();
            $photoLeft->move(public_path('travel'), $photoLeftFileName);
            $photoLeftFilePath = 'travel/' . $photoLeftFileName;
        } else {
            return redirect()->back()->with('error', 'Foto kiri kendaraan tidak ditemukan');
        }

        if ($request->hasFile('photo_back')) {
            $photoBack = $request->file('photo_back');
            $photoBackFileName = $kode . '-back.' . $photoBack->extension();
            $photoBack->move(public_path('travel'), $photoBackFileName);
            $photoBackFilePath = 'travel/' . $photoBackFileName;
        } else {
            return redirect()->back()->with('error', 'Foto belakang kendaraan tidak ditemukan');
        }

        $data = [
            'codeDetailTransportation' => $request->input('codeDetailTransportation'),
            'codeTransportation' => $request->input('codeTransportation'),
            'codeMerk' => $request->input('codeMerk'),
            'vehicle_statuses' => $request->input('vehicle_statuses'),
            'license_plate' => $request->input('license_plate'),
            'driverCode' => $request->input('driverCode'),
            'color' => $request->input('color'),
            'seats' => $request->input('seats'),
            'model' => $request->input('model'),
            'production_year' => $request->input('production_year'),
            'chassis_number' => $request->input('chassis_number'),
            'engine_number' => $request->input('engine_number'),
            'engine_capacity' => $request->input('engine_capacity'),
            'fuel_type' => $request->input('fuel_type'),
            'transmission' => $request->input('transmission'),
            'ownership_status' => $request->input('ownership_status'),
            'registration_date' => $request->input('registration_date'),
            'tax_validity_date' => $request->input('tax_validity_date'),
            'vehicle_condition' => $request->input('vehicle_condition'),
            'insurance_status' => $request->input('insurance_status'),
            'location' => $request->input('location'),
            'photo_front' => $photoFrontFileName,
            'photo_right' => $photoRightFileName,
            'photo_left' => $photoLeftFileName,
            'photo_back' => $photoBackFileName,
            'notes' => $request->input('notes'),
            'user_id' => Auth::user()->id,
        ];

        TransportationsTravelDetail::create($data);
        $seats = $request->input('seats');
        $code = $request->input('codeDetailTransportation');
        for ($i = 1; $i <= $seats; $i++) {
            DetailSeat::create([
                'codeDetailTransportation' => $request->input('codeDetailTransportation'),
                'seat_code' => 'S' . $code . $i,
                'statusSeat' => 'ACTIVE',
            ]);
        }

        return redirect()
            ->route('transportationsTravel.index')
            ->with('message_insert', 'Data Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $transportationsTravel = TransportationsTravelDetail::where('codeDetailTransportation', $id)->first();
            return view('transportationsRental.show')->with([
                'transportationsTravel' => $transportationsTravel,
            ]);
        } catch (\Exception $e) {
            return response()->view('error', [], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $merk = Merk::all();
        $driver = Drivers::all();
        $transportationsTravel = TransportationsTravelDetail::where('codeDetailTransportation', $id)->first();
        // dd($id);
        return view('transportationsTravel.edit')->with([
            'transportationsTravel' => $transportationsTravel,
            'merk' => $merk,
            'driver' => $driver,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehicle = TransportationsTravelDetail::find($id);

        if (!$vehicle) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $kode = date('YmdHis');

        // Simpan nama file awal
        $oldFront = $vehicle->photo_front;
        $oldRight = $vehicle->photo_right;
        $oldLeft  = $vehicle->photo_left;
        $oldBack  = $vehicle->photo_back;

        // Handle upload foto depan
        if ($request->hasFile('photo_front')) {
            $frontPath = public_path('travel/' . $oldFront);
            if (!empty($oldFront) && file_exists($frontPath)) {
                unlink($frontPath);
            }

            $photoFront = $request->file('photo_front');
            $photoFrontFileName = $kode . '-front.' . $photoFront->extension();
            $photoFront->move(public_path('travel'), $photoFrontFileName);
            $vehicle->photo_front = $photoFrontFileName;
        }

        // Handle upload foto kanan
        if ($request->hasFile('photo_right')) {
            $rightPath = public_path('travel/' . $oldRight);
            if (!empty($oldRight) && file_exists($rightPath)) {
                unlink($rightPath);
            }

            $photoRight = $request->file('photo_right');
            $photoRightFileName = $kode . '-right.' . $photoRight->extension();
            $photoRight->move(public_path('travel'), $photoRightFileName);
            $vehicle->photo_right = $photoRightFileName;
        }

        // Handle upload foto kiri
        if ($request->hasFile('photo_left')) {
            $leftPath = public_path('travel/' . $oldLeft);
            if (!empty($oldLeft) && file_exists($leftPath)) {
                unlink($leftPath);
            }

            $photoLeft = $request->file('photo_left');
            $photoLeftFileName = $kode . '-left.' . $photoLeft->extension();
            $photoLeft->move(public_path('travel'), $photoLeftFileName);
            $vehicle->photo_left = $photoLeftFileName;
        }

        // Handle upload foto belakang
        if ($request->hasFile('photo_back')) {
            $backPath = public_path('travel/' . $oldBack);
            if (!empty($oldBack) && file_exists($backPath)) {
                unlink($backPath);
            }

            $photoBack = $request->file('photo_back');
            $photoBackFileName = $kode . '-back.' . $photoBack->extension();
            $photoBack->move(public_path('travel'), $photoBackFileName);
            $vehicle->photo_back = $photoBackFileName;
        }

        // Update data kendaraan
        $vehicle->codeDetailTransportation = $request->input('codeDetailTransportation');
        $vehicle->codeTransportation       = $request->input('codeTransportation');
        $vehicle->codeMerk                 = $request->input('codeMerk');
        $vehicle->driverCode                 = $request->input('driverCode');
        $vehicle->vehicle_statuses         = $request->input('vehicle_statuses');
        $vehicle->license_plate            = $request->input('license_plate');
        $vehicle->color                    = $request->input('color');
        $vehicle->seats                    = $request->input('seats');
        $vehicle->model                    = $request->input('model');
        $vehicle->production_year          = $request->input('production_year');
        $vehicle->chassis_number           = $request->input('chassis_number');
        $vehicle->engine_number            = $request->input('engine_number');
        $vehicle->engine_capacity          = $request->input('engine_capacity');
        $vehicle->fuel_type                = $request->input('fuel_type');
        $vehicle->transmission             = $request->input('transmission');
        $vehicle->ownership_status         = $request->input('ownership_status');
        $vehicle->registration_date        = $request->input('registration_date');
        $vehicle->tax_validity_date        = $request->input('tax_validity_date');
        $vehicle->vehicle_condition        = $request->input('vehicle_condition');
        $vehicle->insurance_status         = $request->input('insurance_status');
        $vehicle->location                 = $request->input('location');
        $vehicle->notes                    = $request->input('notes');
        $vehicle->user_id                  = Auth::user()->id;

        $vehicle->save();

        $code = $request->input('codeDetailTransportation');

        $dataSeat = DetailSeat::where('codeDetailTransportation', $code)->delete();

        $seats = $request->input('seats');
        for ($i = 1; $i <= $seats; $i++) {
            DetailSeat::create([
                'codeDetailTransportation' => $request->input('codeDetailTransportation'),
                'seat_code' => 'S' . $code . $i,
                'statusSeat' => 'ACTIVE',
            ]);
        }

        return redirect()->route('transportationsTravel.index')->with('message_update', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = TransportationsTravelDetail::findOrFail($id);
        $photoFrontFileName = public_path('travel/' . $data->photo_front);
        $photoRightFileName = public_path('travel/' . $data->photo_right);
        $photoLeftFileName = public_path('travel/' . $data->photo_left);
        $photoBackFileName = public_path('travel/' . $data->photo_back);
        $codeDetailTransportation = $data->codeDetailTransportation;

        if (!empty($data->photo_front) && file_exists($photoFrontFileName)) {
            unlink($photoFrontFileName);
        }

        if (!empty($data->photo_right) && file_exists($photoRightFileName)) {
            unlink($photoRightFileName);
        }

        if (!empty($data->photo_left) && file_exists($photoLeftFileName)) {
            unlink($photoLeftFileName);
        }

        if (!empty($data->photo_back) && file_exists($photoBackFileName)) {
            unlink($photoBackFileName);
        }

        $data->delete();
        $dataSeat = DetailSeat::where('codeDetailTransportation', $codeDetailTransportation)->delete();
        return back()->with('message_delete', 'Data Berhasil dihapus');
    }
}
