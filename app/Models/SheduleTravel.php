<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SheduleTravel extends Model
{
    use HasFactory;
    protected $fillable = [
        'codeSchedule',
        'hari',
        'codeRoute',
        'codeDetailTransportation',
    ];

    protected $table = 'schedule_travel';


    public static function codeSchedule()
    {
        $latestRecord = self::orderByRaw("CAST(SUBSTRING(codeSchedule, 3, LENGTH(codeSchedule) - 2) AS UNSIGNED) DESC")->first();
        $latestCodeNumber = optional($latestRecord)->codeSchedule;
        $nextCodeNumber = $latestCodeNumber ? intval(substr($latestCodeNumber, 2)) + 1 : 1;
        return 'ST' . str_pad($nextCodeNumber, 3, '0', STR_PAD_LEFT);
    }

    public function transportation()
    {
        return $this->belongsTo(TransportationsTravelDetail::class, 'codeDetailTransportation', 'codeDetailTransportation');
    }

    public function route()
    {
        return $this->belongsTo(TransportationRoute::class, 'codeRoute', 'codeRoute');
    }

    public function detailTransportation()
    {
        return $this->belongsTo(TransportationsTravelDetail::class, 'codeDetailTransportation', 'codeDetailTransportation');
    }
}
