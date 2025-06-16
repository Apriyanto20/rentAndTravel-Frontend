<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationsTravelDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'codeDetailTransportation',
        'codeTransportation',
        'codeMerk',
        'driverCode',
        'vehicle_statuses',
        'license_plate',
        'color',
        'seats',
        'model',
        'production_year',
        'chassis_number',
        'engine_number',
        'engine_capacity',
        'fuel_type',
        'transmission',
        'ownership_status',
        'registration_date',
        'tax_validity_date',
        'vehicle_condition',
        'insurance_status',
        'location',
        'photo_front',
        'photo_right',
        'photo_left',
        'photo_back',
        'notes',
        'user_id',
    ];

    protected $table = 'transportations_travel_detail';


    public static function codeTravel()
    {
        $latestRecord = self::orderByRaw("CAST(SUBSTRING(codeDetailTransportation, 3, LENGTH(codeDetailTransportation) - 2) AS UNSIGNED) DESC")->first();
        $latestCodeNumber = optional($latestRecord)->codeDetailTransportation;
        $nextCodeNumber = $latestCodeNumber ? intval(substr($latestCodeNumber, 2)) + 1 : 1;
        return 'TT' . str_pad($nextCodeNumber, 3, '0', STR_PAD_LEFT);
    }

    public function merk()
    {
        return $this->belongsTo(Merk::class, 'codeMerk', 'codeMerk');
    }

    public function transportation()
    {
        return $this->belongsTo(Transportations::class, 'codeTransportation', 'codeTransportation');
    }

    public function seat()
    {
        return $this->belongsTo(DetailSeat::class, 'codeDetailTransportation', 'codeDetailTransportation');
    }

    public function detailSeats()
    {
        return $this->hasMany(DetailSeat::class, 'codeDetailTransportation', 'codeDetailTransportation');
    }
}
