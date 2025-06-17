<?php

namespace App\Http\Controllers;

use App\Models\DetailSeat;
use App\Models\Members;
use App\Models\SheduleTravel;
use App\Models\TransactionsTravel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class transportationTravelMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tgl = $request->tgl_berangkat ?? date('Y-m-d');
        $dayEnglish = date('l', strtotime($tgl)); // misal: 'Wednesday'

        $dayMap = [
            'Sunday' => 'MINGGU',
            'Monday' => 'SENIN',
            'Tuesday' => 'SELASA',
            'Wednesday' => 'RABU',
            'Thursday' => 'KAMIS',
            'Friday' => 'JUMAT',
            'Saturday' => 'SABTU',
        ];

        $day = $dayMap[$dayEnglish] ?? null;

        $data = SheduleTravel::with(['transportation', 'route'])
            ->where('hari', $day)
            ->get();

        return view('scheduleTravelMember.index', [
            'data' => $data,
            'tgl' => $tgl
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
        $email = Auth::user()->email;
        $name = Auth::user()->name;
        $dataUser = Members::where('email', $email)->first();
        $nik = $dataUser->nik;

        $seatCode = $request->input('seatCode');

        $data = [
            'codeSchedule' => $request->input('id'),
            'seat_code' => $request->input('seatCode'),
            'nik' => $nik,
            'name' => $name,
            'price' => $request->input('routePrice'),
            'paymentStatus' => 'WAITING',
            'paymentMethod' => $request->input('paymentMethod'),
            'proofOfPayment' => '',
            'notes' => '-',
            'tgl_berangkat' => $request->input('tgl_berangkat'),
        ];

        TransactionsTravel::create($data);

        $data = [
            'statusSeat' => 'WAITING',
        ];

        $datas = DetailSeat::where('seat_code', $seatCode)->first();
        $datas->update($data);

        return back()->with('message_insert', 'Data Sudah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tglBerangkat = request('tgl_berangkat');
        $data = SheduleTravel::with([
            'detailTransportation.detailSeats'
        ])->where('id', $id)->get();
        return view('scheduleTravelMember.seat')->with([
            'data' => $data,
            'tglBerangkat' => $tglBerangkat,
        ]);
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
