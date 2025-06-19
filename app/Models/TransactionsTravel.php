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

    public function transportationTravel()
    {
        return $this->belongsTo(TransportationsTravelDetail::class, 'codeDetailTransportation', 'codeDetailTransportation');
    }

    public function schedule()
    {
        return $this->belongsTo(SheduleTravel::class, 'codeSchedule', 'codeSchedule');
    }

    public static function singkat($nama)
    {
        $nama = strtoupper($nama);
        $vokal = ['A', 'I', 'U', 'E', 'O'];
        $hasil = '';

        for ($i = 0; $i < strlen($nama); $i++) {
            if (!in_array($nama[$i], $vokal)) {
                $hasil .= $nama[$i];
                if (strlen($hasil) == 3) break;
            }
        }

        return $hasil;
    }
}
