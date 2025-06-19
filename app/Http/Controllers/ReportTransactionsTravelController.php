<?php

namespace App\Http\Controllers;

use App\Exports\ReportTravelExport;
use App\Models\TransactionsTravel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class ReportTransactionsTravelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->input('page', 1);
        $entries = request()->input('entries', 10);
        $search = request()->input('search');
        $paymentStatus = request()->input('paymentStatus');
        $travelStartDate = request()->input('travelStartDate');
        $travelEndDate = request()->input('travelEndDate');

        $hasFilter = $search || $paymentStatus || $travelStartDate || $travelEndDate;

        if ($hasFilter) {
            $query = TransactionsTravel::with(['member', 'transportationTravel.transportation', 'transportationTravel.merk'])
                ->orderBy('created_at', 'DESC');

            if ($search) {
                $query->whereHas('member', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }

            if ($paymentStatus) {
                $query->where('paymentStatus', $paymentStatus);
            }

            if ($travelStartDate && $travelEndDate) {
                $query->whereBetween('tgl_berangkat', [$travelStartDate, $travelEndDate]);
            }

            $transactionsTravel = $query->paginate($entries);
        } else {
            $transactionsTravel = new LengthAwarePaginator([], 0, $entries, $page, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);
        }
        return view('reportTravel.index', compact('transactionsTravel', 'hasFilter'))
            ->with('i', ($page - 1) * $entries);
    }

    public function exportExcel(Request $request)
    {
        $paymentStatus = $request->paymentStatus;
        $rentalStartDate = $request->rentalStartDate;
        $rentalEndDate = $request->rentalEndDate;

        return Excel::download(
            new ReportTravelExport($paymentStatus, $rentalStartDate, $rentalEndDate),
            'report-rental.xlsx'
        );
    }

    public function pdf(Request $request)
    {
        $paymentStatus = $request->paymentStatus;

        $data = [
            'paymentStatus' => $paymentStatus,
        ];

        $pdf = Pdf::loadView('exports.report-travel-pdf', $data);
        return $pdf->download('travel-report.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $paymentStatus = $request->paymentStatus;
        $travelStartDate = $request->travelStartDate;
        $travelEndDate = $request->travelEndDate;

        $data = TransactionsTravel::with(['member'])
            ->when($paymentStatus, fn($q) => $q->where('paymentStatus', $paymentStatus))
            ->when($travelStartDate && $travelEndDate, fn($q) => $q->whereBetween('tgl_berangkat', [$travelStartDate, $travelEndDate]))
            ->when($travelStartDate && !$travelEndDate, fn($q) => $q->whereDate('tgl_berangkat', '>=', $travelStartDate))
            ->when(!$travelStartDate && $travelEndDate, fn($q) => $q->whereDate('tgl_berangkat', '<=', $travelEndDate))
            ->get();
        if ($data->isEmpty()) {
            $pdf = Pdf::loadView('exports.empty-pdf');
        } else {
            $pdf = Pdf::loadView('exports.report-travel-pdf', ['data' => $data, 'travelStartDate' => $travelStartDate, 'travelEndDate' => $travelEndDate]);
        }
        return $pdf->download('travel-report.pdf');
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
