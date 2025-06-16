<?php

namespace App\Http\Controllers;

use App\Models\DetailSeat;
use App\Models\TransactionsTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TransactionsTravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->input('page', 1);
        $entries = request()->input('entries', 10);
        $search = request()->input('search');

        $query = TransactionsTravel::query();

        /*if ($search) {
                $query->where('merk.merk', 'like', '%' . $search . '%')
                    ->orWhere('transportations.transportation', 'like', '%' . $search . '%');
            }*/

        $transactionsTravel = $query->paginate($entries);

        return view('transactionsTravel.index', compact(['transactionsTravel']))
            ->with('i', ($page - 1) * $entries);
    }

    public function checkExpired(Request $request)
    {
        $transaction = TransactionsTravel::find($request->id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $expiredAt = Carbon::parse($transaction->created_at)->addMinutes(1);

        if (now()->greaterThanOrEqualTo($expiredAt) && !$transaction->proofOfPayment && $transaction->rentalStatus === "WAITING" && $transaction->paymentStatus === "WAITING") {

            if ($transaction->seat_code) {
                DetailSeat::where('seat_code', $transaction->seat_code)
                    ->update(['statusSeat' => 'ACTIVE']);
            }

            return response()->json(['updated' => true]);
        }

        return response()->json(['updated' => false]);
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
