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
        $day = '';

        if (date('l') == 'Sunday') {
            $day = 'MINGGU';
        } elseif (date('l') == 'Monday') {
            $day = 'SENIN';
        } elseif (date('l') == 'Tuesday') {
            $day = 'SELASA';
        } elseif (date('l') == 'Wednesday') {
            $day = 'RABU';
        } elseif (date('l') == 'Thursday') {
            $day = 'KAMIS';
        } elseif (date('l') == 'Friday') {
            $day = 'JUMAT';
        } elseif (date('l') == 'Saturday') {
            $day = 'SABTU';
        }
        $query = SheduleTravel::query()->where('hari', $day);

        $data = $query->get();
        return view('scheduleTravelMember.index')->with([
            'data' => $data,
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
        //$data = SheduleTravel::with(['transportation', 'transportation.seat'])->findOrFail($id);
        $data = SheduleTravel::with([
            'detailTransportation.detailSeats'
        ])->where('id', $id)->get();
        return view('scheduleTravelMember.seat')->with([
            'data' => $data
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
