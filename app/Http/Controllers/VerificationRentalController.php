<?php

namespace App\Http\Controllers;

use App\Models\TransactionsRental;
use Illuminate\Http\Request;

class VerificationRentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->input('page', 1);
        $entries = request()->input('entries', 10);
        $search = request()->input('search');

        $query = TransactionsRental::where('rentalStatus', 'RENTAL');

        if ($search) {
            $query->where('merk.merk', 'like', '%' . $search . '%')
                ->orWhere('transportations.transportation', 'like', '%' . $search . '%');
        }

        $transactionsRental = $query->paginate($entries);

        return view('verificationRental.index', compact(['transactionsRental']))
            ->with('i', ($page - 1) * $entries);
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
        $data = [
            'rentalStatus' => 'SELESAI'
        ];

        $datas = TransactionsRental::findOrFail($id);
        $datas->update($data);
        return back()->with('message_update', 'Data Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
