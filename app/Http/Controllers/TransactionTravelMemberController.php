<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\TransactionsTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionTravelMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->email;
        $member = Members::where('email', $user)->first();
        $nik = $member->nik;
        $photo = $member->photo;
        $data = TransactionsTravel::where('nik', $nik)->get();
        //dd($data);
        return view('historyTravel.index')->with([
            'data' => $data,
            'photo' => $photo,
            'member' => $member,
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
        $transaction = TransactionsTravel::findOrFail($id);
        $kode = date('YmdHis');
        if ($request->hasFile('proof_of_payment')) {
            $proofOfPayment = $request->file('proof_of_payment');
            $proofOfPaymentFileName = $kode . '-qris.' . $proofOfPayment->extension();
            $proofOfPayment->move(public_path('travel/payment/'), $proofOfPaymentFileName);

            $transaction->proofOfPayment = $proofOfPaymentFileName;
            $transaction->paymentStatus = 'SUCCESS';
            $transaction->save();

            return redirect()->back()->with('message_insert', 'Pembayaran Success');
        } else {
            return redirect()->back()->with('error', 'Bukti Pembayaran tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
