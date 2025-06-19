<?php

namespace App\Exports;

use App\Models\TransactionsTravel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportTravelExport implements FromCollection, WithHeadings
{
    protected $paymentStatus;
    protected $travelStartDate;
    protected $travelEndDate;

    public function __construct($paymentStatus, $travelStartDate, $travelEndDate)
    {
        $this->paymentStatus = $paymentStatus;
        $this->travelStartDate = $travelStartDate;
        $this->travelEndDate = $travelEndDate;
    }

    public function collection()
    {
        return TransactionsTravel::with(['member', 'transportationTravel'])
            ->when($this->paymentStatus, fn($q) => $q->where('paymentStatus', $this->paymentStatus))
            ->when($this->travelStartDate, fn($q) => $q->whereDate('tgl_berangkat', '>=', $this->travelStartDate))
            ->when($this->travelEndDate, fn($q) => $q->whereDate('tgl_berangkat', '<=', $this->travelEndDate))->get()
            ->map(function ($item) {
                return [
                    $item->created_at,
                    $item->member->nik ?? '-',
                    $item->member->name ?? '-',
                    $item->price,
                    $item->paymentMethod,
                    $item->paymentStatus,
                    $item->tgl_berangkat,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'WAKTU TRANSAKSI',
            'KODE MEMBER',
            'MEMBER',
            'HARGA',
            'METODE PEMBAYARAN',
            'STATUS PEMBAYARAN',
            'TANGGAL BERANGKAT',
        ];
    }
}
