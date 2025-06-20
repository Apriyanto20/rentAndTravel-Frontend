<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DetailSeatController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\HistoryDriverController;
use App\Http\Controllers\HistoryMemberController;
use App\Http\Controllers\HonorDriverController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalOptionsController;
use App\Http\Controllers\ReportTransactionsRentalController;
use App\Http\Controllers\ReportTransactionsTravelController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleTravelController;
use App\Http\Controllers\TransactionsRentalController;
use App\Http\Controllers\TransactionsTravelController;
use App\Http\Controllers\TransactionTravelMemberController;
use App\Http\Controllers\TransportationRentalMemberController;
use App\Http\Controllers\TransportationsController;
use App\Http\Controllers\TransportationsRentalDetailController;
use App\Http\Controllers\TransportationsRentalMotorcyleController;
use App\Http\Controllers\TransportationsRouteController;
use App\Http\Controllers\TransportationsTravelController;
use App\Http\Controllers\TransportationsTravelDetailController;
use App\Http\Controllers\transportationTravelMemberController;
use App\Http\Controllers\VerificationRentalController;
use App\Models\DetailSeat;
use App\Models\Drivers;
use App\Models\TransactionsRental;
use App\Models\TransactionsTravel;
use App\Models\TransportationsRentalDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Ketika buka halaman utama, redirect ke /login
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Halaman login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
});

Route::get('/dashboard', function () {
    $driverCode = optional(Drivers::where('email', Auth::user()->email)->first())->nik;

    $page     = request('page', 1);
    $entries  = request('entries', 10);
    $search   = request('search');

    $transactionsRental = TransactionsRental::where('driverCode', $driverCode)
        ->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->whereRelation('transportationRental.merk', 'merk', 'like', "%{$search}%");
            });
        })
        ->paginate($entries);

    // Hitung honor bulan ini
    $month = Carbon::now()->month;
    $year  = Carbon::now()->year;

    $result = DB::table('drivers AS d')
        ->join('transactions_rental AS tr', 'tr.driverCode', '=', 'd.nik')
        ->where('d.nik', $driverCode)
        ->whereMonth('tr.created_at', $month)
        ->whereYear('tr.created_at', $year)
        ->groupBy('d.nik', 'd.prices')      // ← penambahan penting
        ->selectRaw('
        d.prices AS harga_per_hari,
        SUM(DATEDIFF(tr.rentalEndDate, tr.rentalStartDate) + 1)                AS total_hari,
        SUM((DATEDIFF(tr.rentalEndDate, tr.rentalStartDate) + 1) * d.prices)   AS total_honor
    ')
        ->first();

    $totalHariKerja = $result->total_hari   ?? 0;
    $honorNow     = $result->total_honor  ?? 0;

    $prev      = Carbon::now()->subMonth();   // contoh: sekarang 11-06-2025 ⇒ $prev = 11-05-2025
    $monthPrev = $prev->month;                // 5
    $yearPrev  = $prev->year;

    $resultPrev = DB::table('drivers AS d')
        ->join('transactions_rental AS tr', 'tr.driverCode', '=', 'd.nik')
        ->where('d.nik', $driverCode)
        ->whereMonth('tr.created_at', $monthPrev)
        ->whereYear('tr.created_at', $yearPrev)
        ->groupBy('d.nik', 'd.prices')      // ← penambahan penting
        ->selectRaw('
        d.prices AS harga_per_hari,
        SUM(DATEDIFF(tr.rentalEndDate, tr.rentalStartDate) - 1)                AS total_hari,
        SUM((DATEDIFF(tr.rentalEndDate, tr.rentalStartDate) - 1) * d.prices)   AS total_honor
    ')
        ->first();

    $totalHariKerjaPrev = $resultPrev->total_hari   ?? 0;
    $honorPrev     = $resultPrev->total_honor  ?? 0;

    $dailyHonor = DB::table('transactions_rental AS tr')
        ->join('drivers AS d', 'd.nik', '=', 'tr.driverCode')
        ->where('d.nik', $driverCode)
        ->whereMonth('tr.created_at', $month)
        ->whereYear('tr.created_at',  $year)
        ->selectRaw('DATE(tr.created_at) AS tanggal,
                 SUM((DATEDIFF(tr.rentalEndDate, tr.rentalStartDate)+1)*d.prices) AS honor_harian')
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

    /* --- siapkan array label & data untuk Chart.js --- */
    $labels = $dailyHonor->pluck('tanggal')
        ->map(fn($tgl) => Carbon::parse($tgl)->format('M d'))
        ->toArray();

    $dataPoints = $dailyHonor->pluck('honor_harian')
        ->map(fn($v) => (float) $v)
        ->toArray();

    return view('dashboard', compact('transactionsRental', 'totalHariKerja', 'honorNow', 'honorPrev', 'monthPrev', 'labels', 'dataPoints'))
        ->with('i', ($page - 1) * $entries);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/coba', function () {
    return view('coba');
})->middleware(['auth', 'verified'])->name('coba');

Route::get('/cobaLoop', function () {
    return view('cobaLoop');
})->middleware(['auth', 'verified'])->name('cobaLoop');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('transportations', TransportationsController::class);
    Route::resource('merks', MerkController::class);
    Route::resource('rentalOptions', RentalOptionsController::class);
    Route::resource('members', MemberController::class);
    Route::get('drivers/export/', [DriverController::class, 'export'])->name('drivers.export');
    Route::resource('drivers', DriverController::class);
    Route::resource('transportationRoutes', TransportationsRouteController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('historyMember', HistoryMemberController::class);

    Route::resource('transportationsRental', TransportationsRentalDetailController::class);
    Route::resource('transportationsRentalMotorcycle', TransportationsRentalMotorcyleController::class);
    Route::resource('detailSeat', DetailSeatController::class);
    Route::resource('trasnportationsTravel', TransportationsTravelDetailController::class);
    Route::resource('scheduleTravel', ScheduleTravelController::class);
    Route::resource('transactionsTravel', TransactionsTravelController::class);
    Route::resource('transactionsRental', TransactionsRentalController::class);
    Route::resource('reportRental', ReportTransactionsRentalController::class);
    Route::resource('transportationRentalMember', TransportationRentalMemberController::class);
    Route::resource('verificationRental', VerificationRentalController::class);
    Route::resource('historyDriverRental', HistoryDriverController::class);
    Route::resource('honor', HonorDriverController::class);

    Route::resource('transportationsTravel', TransportationsTravelController::class);
    Route::resource('schedule', ScheduleTravelController::class);
    Route::resource('transportationTravelMember', transportationTravelMemberController::class);
    Route::post('/transportationsTravel/check-expired', [TransportationsTravelController::class, 'checkExpired'])->name('transportationsTravel.checkExpired');
    Route::post('/transactionsTravel/cancel/{id}', function ($id) {
        $trans = TransactionsTravel::find($id);

        // Pastikan transaksi ditemukan dan memenuhi kondisi
        if ($trans && !$trans->proofOfPayment && $trans->paymentStatus !== 'CANCEL') {
            $seatCode = $trans->seat_code;

            // Ambil detail seat berdasarkan seat_code
            $detailSeat = DetailSeat::where('seat_code', $seatCode)->first();

            $trans->paymentStatus = 'CANCEL';
            $trans->save();

            // Pastikan detail seat ditemukan
            if ($detailSeat) {
                $detailSeat->statusSeat = 'ACTIVE';
                $detailSeat->save();
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    });

    Route::resource('transactionTravelMember', TransactionTravelMemberController::class);
    Route::resource('reportTravel', ReportTransactionsTravelController::class);
    Route::get('/reportTravel/pdf', [ReportTransactionsTravelController::class, 'pdf'])->name('reportTravel.pdf');
    Route::get('/reportTravel/export/excel', [ReportTransactionsTravelController::class, 'exportExcel'])->name('reportTravel.export.excel');

    Route::get('/generate-code-detail/{type}', [TransportationsRouteController::class, 'generateCodeDetail']);
    Route::get('/transportations-rental/{slug}', [TransportationsRouteController::class, 'category'])->name('transportationsRental.category');
    Route::get('/transactionsRental/create/{codeDetailTransportation}', [TransactionsRentalController::class, 'create'])->name('transactionsRental.create.withCode');
    Route::put('/transactions-rental/{id}', [TransactionsRentalController::class, 'updateStatus'])->name('transactionsRental.updateStatus');
    Route::put('/transactions-rental/{id}/update-pembayaran', [TransactionsRentalController::class, 'updatePembayaran'])->name('transactionsRental.updatePembayaran');
    Route::post('/transactions-rental/{id}/auto-cancel', [TransactionsRentalController::class, 'autoCancel']);
    Route::post('/transactions/check-expired', [TransactionsRentalController::class, 'checkExpired'])->name('transactions.checkExpired');
    Route::get('/reportRental/pdf', [ReportTransactionsRentalController::class, 'pdf'])->name('reportRental.pdf');
    Route::get('/reportRental/export/excel', [ReportTransactionsRentalController::class, 'exportExcel'])->name('reportRental.export.excel');

    Route::get('/get-driver/{nik}', function ($nik) {
        $driver = Drivers::where('nik', $nik)->first();

        if (!$driver) {
            return response()->json(['error' => 'Driver tidak ditemukan'], 404);
        }

        return response()->json([
            'experience' => $driver->workExperience,
            'prices' => $driver->prices,
        ]);
    });
});
Route::get('/cek-nik', function (Request $request) {
    try {
        $nik = Request::get('nik'); // Gunakan input() atau query()

        if (!$nik) {
            return response()->json(['error' => 'NIK tidak boleh kosong'], 400);
        }

        $exists = DB::table('members')->where('nik', $nik)->exists();

        return response()->json(['exists' => $exists]);
    } catch (\Exception $e) {
        Log::error($e->getMessage()); // Log error ke Laravel Log
        return response()->json(['error' => 'Terjadi kesalahan server'], 500);
    }
});

Route::get('/cek-email', function (Request $request) {
    try {
        $email = Request::get('email'); // Gunakan input() atau query()

        if (!$email) {
            return response()->json(['error' => 'NIK tidak boleh kosong'], 400);
        }

        $exists = DB::table('members')->where('email', $email)->exists() ||
            DB::table('users')->where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    } catch (\Exception $e) {
        Log::error($e->getMessage()); // Log error ke Laravel Log
        return response()->json(['error' => 'Terjadi kesalahan server'], 500);
    }
});

Route::get('/cek-nik-driver', function (Request $request) {
    try {
        $nik = Request::get('nik'); // Gunakan input() atau query()

        if (!$nik) {
            return response()->json(['error' => 'NIK tidak boleh kosong'], 400);
        }

        $exists = DB::table('drivers')->where('nik', $nik)->exists();

        return response()->json(['exists' => $exists]);
    } catch (\Exception $e) {
        Log::error($e->getMessage()); // Log error ke Laravel Log
        return response()->json(['error' => 'Terjadi kesalahan server'], 500);
    }
});

Route::get('/cek-email-driver', function (Request $request) {
    try {
        $email = Request::get('email'); // Gunakan input() atau query()

        if (!$email) {
            return response()->json(['error' => 'NIK tidak boleh kosong'], 400);
        }

        $exists = DB::table('drivers')->where('email', $email)->exists() ||
            DB::table('users')->where('email', $email)->exists();

        return response()->json(['exists' => $exists]);
    } catch (\Exception $e) {
        Log::error($e->getMessage()); // Log error ke Laravel Log
        return response()->json(['error' => 'Terjadi kesalahan server'], 500);
    }
});

require __DIR__ . '/auth.php';
