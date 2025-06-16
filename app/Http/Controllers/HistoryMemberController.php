<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\TransactionsRental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->email;

        $member = Members::where('email', $user)->first();
        $memberCode = $member->nik;

        $page = request()->input('page', 1);
        $entries = request()->input('entries', 10);
        $search = request()->input('search');

        $query = TransactionsRental::where('memberCode', $memberCode);
        if ($search) {
            $query->where('merk.merk', 'like', '%' . $search . '%')
                ->orWhere('transportations.transportation', 'like', '%' . $search . '%');
        }
        $transactionsRental = $query->paginate($entries);
        return view('history.index', compact(['transactionsRental']))
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
