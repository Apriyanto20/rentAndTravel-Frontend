<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_schedule;');
        DB::statement('
                CREATE VIEW vw_schedule AS
                SELECT schedule_travel.codeSchedule, transportation_route.codeRoute, transportation_route.route, transportation_route.route_price, schedule_travel.hari, schedule_travel.codeDetailTransportation, transportations_travel_detail.driverCode,  drivers.name, transportations_travel_detail.seats, transportations_travel_detail.model, detail_seat.seat_code, detail_seat.statusSeat FROM `schedule_travel`
                JOIN transportations_travel_detail ON transportations_travel_detail.codeDetailTransportation = schedule_travel.codeDetailTransportation
                JOIN detail_seat ON detail_seat.codeDetailTransportation = transportations_travel_detail.codeDetailTransportation
                JOIN drivers ON transportations_travel_detail.driverCode = drivers.nik
                JOIN transportation_route ON schedule_travel.codeRoute = transportation_route.codeRoute;
            ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_schedule;');
    }
};
