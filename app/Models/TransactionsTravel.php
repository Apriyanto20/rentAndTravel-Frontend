<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsTravel extends Model
{
    use HasFactory;
    protected $fillable = [
        'codeSchedule',
        'seat_code',
        'nik',
        'name',
        'price',
        'paymentStatus',
        'paymentMethod',
        'proofOfPayment',
        'notes',
        'tgl_berangkat',
    ];

    protected $table = 'transactions_travel';

    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'driverCode', 'nik');
    }

    public function member()
    {
        return $this->belongsTo(Members::class, 'nik', 'nik');
    }

    public function transportationRental()
    {
        return $this->belongsTo(TransportationsRentalDetail::class, 'codeDetailTransportation', 'codeDetailTransportation');
    }
}
