<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\TransactionsRental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Members::where('email', Auth::user()->email)->first();
        $nik = $user->nik;
        //$data = TransactionsRental::where('paymentStatus', 'WAITING FOR PAYMENT')->where('memberCode', $nik)->first();
        $data = TransactionsRental::where('memberCode', $nik)->orderBy('created_at','desc')->first();
        return view('pembayaran.index')->with([
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
