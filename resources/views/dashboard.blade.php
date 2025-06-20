<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            @can('role-D')
                <div class="flex items-center gap-5">
                    <div class="w-full">
                        <div class="font-bold text-gray-500 -mb-4">Balance</div>
                        <div class="text-[50px]">Rp {{ number_format($honorNow) }}</div>
                        <div class="font-bold text-gray-500 -mt-2">as of {{ date('d/m/Y') }}</div>
                    </div>
                    <div class="w-full">
                        {{-- <div><canvas id="acquisitions" style="width: 800px; height: 200px;"></canvas></div> --}}
                        <div class="chart-container">
                            <canvas id="balanceChart" style="width: 900px; height: 200px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="flex gap-5 mt-4">
                    <div class="flex items-center justify-between w-full border-2 border-gray-300 p-4 rounded-xl">
                        <div class="w-full">
                            <div class="text-emerald-800 text-xl font-bold">Income Bulan Lalu</div>
                            <div class="text-3xl font-bold text-emerald-800">Rp {{ number_format($honorPrev) }}</div>
                            <div class="text-wrap text-gray-400">Lorem ipsum dolor sit, <br>amet consectetur adipisicing
                                elit.</div>
                        </div>
                        <div class="w-1/2 flex items-end justify-end">
                            <span
                                class="bg-amber-100 font-bold text-gray-500 px-4 rounded-full">{{ date('M', strtotime('-1 month')) }}
                                {{ date('Y') }}
                                (Q3)</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between w-full border-2 border-gray-300 p-4 rounded-xl">
                        <div class="w-full">
                            <div class="text-emerald-800 text-xl font-bold">Performa Driver</div>
                            <div class="flex gap-2 items-center">
                                <div class="text-3xl font-bold text-emerald-800">5%</div>
                                <div class="flex rounded-xl overflow-hidden border border-emerald-300">
                                    <div class="bg-emerald-600 text-white px-2 py-1 text-sm font-semibold">% </div>
                                    <div class="text-emerald-800 px-2 py-1 text-sm font-semibold bg-white">S</div>
                                </div>
                            </div>
                            <div class="text-wrap text-gray-400">Lorem ipsum dolor sit, <br>amet consectetur adipisicing
                                elit.</div>
                        </div>
                        <div class="border-2 h-24 mr-8"></div>
                        <div class="w-full flex items-end justify-end">
                            <div class="relative w-full max-w-md">
                                <!-- Slider track -->
                                <div class="h-2 bg-gray-200 rounded-full relative">
                                    <!-- Active fill bar -->
                                    <div class="absolute h-2 bg-red-400 rounded-full left-0 w-[10%]"></div>

                                    <!-- Thumb -->
                                    <div
                                        class="absolute top-[-3px] left-[25px] w-3 h-3 shadow-2xl bg-white rounded-full z-10">
                                    </div>

                                    <!-- Markers -->
                                    <div class="absolute left-[10%] top-[-5px] w-0.5 h-4 bg-red-500"></div>
                                    <div class="absolute left-[50%] top-[-5px] w-0.5 h-4 bg-yellow-500"></div>
                                    <div class="absolute left-[90%] top-[-5px] w-0.5 h-4 bg-green-500"></div>
                                </div>

                                <!-- Labels -->
                                <div class="flex justify-between text-xs font-semibold mt-2 px-1">
                                    <span class="text-red-600">MINIMUM</span>
                                    <span class="text-yellow-600">RECOMMENDED</span>
                                    <span class="text-green-600">MAXIMUM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-5 mt-4">
                    <div class="w-full border-2 border-gray-300 p-4 rounded-xl">
                        <div class="w-full">
                            <div class="text-emerald-800 text-xl font-bold">Apa saja yang harus dimiliki oleh driver?</div>
                            <div class="text-wrap text-gray-400 mt-3 text-sm">Lorem ipsum dolor sit amet consectetur
                                adipisicing elit. Incidunt eveniet suscipit enim adipisci id commodi quis placeat rerum
                                corporis perferendis.</div>
                        </div>
                        <div class="space-y-6 mt-3">
                            <div class="flex items-start gap-3 border-b pb-4">
                                <div class="mt-1">
                                    <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                            stroke-width="3" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-md font-semibold text-gray-800">Technical Skills Improvement</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Continually improving your HVAC skills can lead to better performance on the job...
                                    </p>
                                    <a href="#"
                                        class="text-green-600 text-sm mt-2 inline-block hover:underline">Resources</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 border-b pb-4">
                                <!-- Empty Circle -->
                                <div class="mt-1">
                                    <div class="w-5 h-5 border-2 border-gray-400 rounded-full"></div>
                                </div>

                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-md font-semibold text-gray-800">Effective Collaboration</h3>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Work well with your team. Share knowledge, assist when needed...
                                    </p>
                                    <a href="#"
                                        class="text-green-600 text-sm mt-2 inline-block hover:underline">Resources</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="mt-1">
                                    <div class="w-5 h-5 border-2 border-gray-400 rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-md font-semibold text-gray-800">Time Management Skills</h3>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        The faster and more efficiently you can complete tasks without sacrificing
                                        quality...
                                    </p>
                                    <a href="#"
                                        class="text-green-600 text-sm mt-2 inline-block hover:underline">Resources</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="w-full">
                        <div class="items-center justify-between w-full border-2 border-gray-300 p-4 rounded-xl mb-5">
                            <div class="w-full">
                                <div class="text-emerald-800 text-xl font-bold">Pengalaman Kerja Driver</div>
                                <div class="flex justify-between items-center gap-2 mt-4">
                                    <div class="text-[50px] font-bold text-emerald-800">3,4 <span
                                            class="text-sm">Tahun</span></div>
                                    <div class="flex space-x-1">
                                        <div class="step active">1</div>
                                        <div class="step active">2</div>
                                        <div class="step active">3</div>
                                        <div class="step">4</div>
                                        <div class="step">5</div>
                                        <div class="step">6</div>
                                        <div class="step">7</div>
                                        <div class="step">8</div>
                                        <div class="step">9</div>
                                        <div class="step">10</div>
                                    </div>
                                </div>
                                <div class="text-wrap text-gray-400 text-sm mt-4">Lorem ipsum dolor sit amet consectetur
                                    adipisicing elit. Aliquid eaque enim rem facere inventore omnis molestiae quibusdam
                                    error repudiandae iste.</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between w-full border-2 border-gray-300 p-4 rounded-xl">
                            <div class="w-full">
                                <div class="text-emerald-800 text-xl font-bold">Perusahaan</div>
                                <div class="mt-4 text-sm">
                                    <div class="grid grid-cols-2 gap-5">
                                        <div>
                                            <div class="text-gray-500 font-bold">Nama</div>
                                            <div class="font-bold">Apa Aja</div>
                                        </div>
                                        <div>
                                            <div class="text-gray-500 font-bold">Contact Person</div>
                                            <div class="font-bold">Adi Apriyanto (Manager Directur)</div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-5 mt-4">
                                        <div>
                                            <div class="text-gray-500 font-bold">Alamat</div>
                                            <div class="font-bold text-wrap">Lorem ipsum, dolor sit amet consectetur
                                                adipisicing elit. Numquam rerum voluptatum at nulla iure corporis fugiat eos
                                                expedita eius aliquid!</div>
                                        </div>
                                        <div>
                                            <div class="text-gray-500 font-bold">Nomor Telepon</div>
                                            <div class="font-bold">(026) 5311766</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 border-2 border-gray-300 p-4 rounded-xl">
                    <div class="text-emerald-800 text-xl font-bold">History Rental</div>
                    <div class="flex justify-center mt-4">
                        <div class="p-0 " style="width:100%;overflow-x:auto;">
                            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                                <div class="md:mt-0 sm:flex sm:space-x-4 w-full">
                                    <!-- Form untuk entries -->
                                    <x-show-entries :route="route('dashboard')" :search="request()->search">
                                    </x-show-entries>
                                </div>
                                <div class="sm:ml-16 sm:mt-0 sm:flex sm:space-x-4 sm:flex-none">
                                    <form action="{{ route('dashboard') }}" method="GET"
                                        class="flex items-center flex-1">
                                        <input type="text" name="search" placeholder="Enter for search . . . "
                                            id="search" value="{{ request('search') }}"
                                            class="w-56 relative inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300"
                                            oninput="this.value = this.value.toUpperCase();" />

                                        <input type="hidden" name="entries" value="{{ request('entries', 10) }}">
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                    </form>
                                </div>
                            </div>
                            <div class="relative overflow-x-auto rounded-lg shadow-lg">
                                <div class="overflow-x-auto">
                                    <table class="table-auto w-full text-sm text-left text-gray-500 border">
                                        <thead class="text-md font-bold text-gray-700 uppercase">
                                            <tr>
                                                <th scope="col" class="px-3 py-2 text-center">NO</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">WAKTU
                                                    TRANSAKSI</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">MEMBER KODE
                                                </th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">MEMBER</th>
                                                <th scope="col" class="px-3 py-2 text-center">TRANSPORTASI</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">WAKTU
                                                    RENTAL</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">HONOR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = $transactionsRental->firstItem();
                                            @endphp
                                            @forelse($transactionsRental as $i)
                                                <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700"
                                                    data-expired-at="{{ \Carbon\Carbon::parse($i->created_at)->addMinutes(15) }}"
                                                    data-proof="{{ $i->proofOfPayment }}">
                                                    <td class="px-3 py-2 text-center">{{ $no++ }}</td>
                                                    <td class="px-3 py-2 text-center">{{ $i->created_at }}</td>
                                                    <td class="px-3 py-2 text-center bg-gray-100">
                                                        {{ $i->member->nik }}
                                                    </td>
                                                    <td class="px-3 py-2 text-center bg-gray-100">
                                                        {{ $i->member->name }}
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        {{ $i->transportationRental->transportation->transportation }}
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        {{ date('d-m-Y', strtotime($i->rentalStartDate)) }} <span
                                                            class="font-bold text-red-500">s/d</span>
                                                        {{ date('d-m-Y', strtotime($i->rentalEndDate)) }}</td>
                                                    @php
                                                        $countDay =
                                                            \Carbon\Carbon::parse($i->rentalStartDate)->diffInDays(
                                                                \Carbon\Carbon::parse($i->rentalEndDate),
                                                            ) + 1;
                                                    @endphp
                                                    <td class="px-3 py-2 text-center">
                                                        {{ $i->driver->prices * $countDay }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4"
                                                        class="px-3 py-2 text-center bg-gray-500 text-white">
                                                        Data Belum Tersedia!
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-4">
                                @if ($transactionsRental->hasPages())
                                    {{ $transactionsRental->appends(request()->query())->links('vendor.pagination.custom') }}
                                @else
                                    <div class="flex items-center justify-between">
                                        <nav class="flex justify-start">
                                            <div class="text-sm flex gap-1">
                                                <div>Showing</div>
                                                <div class="font-bold">1</div>
                                                <div>to</div>
                                                <div class="font-bold">{{ count($transactionsRental) }}</div>
                                                <div>of</div>
                                                <div class="font-bold">{{ count($transactionsRental) }}</div>
                                                <div>entries</div>
                                            </div>
                                        </nav>
                                        <div class="flex items-center space-x-2">
                                            <div class="flex">
                                                <div class="border px-4 py-1 rounded-l-lg">&lt;</div>
                                                <div class="border px-4 py-1">1</div>
                                                <div class="border px-4 py-1 rounded-r-lg">&gt;</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('role-M')
                <div class="grid grid-cols-4 gap-5">
                    <div
                        class="w-full bg-emerald-100 border-2 border-emerald-300 p-5 rounded-3xl flex items-center justify-between">
                        <div class="font-bold text-emerald-500">Transportasi Rental</div>
                        <div class="font-bold text-xl text-emerald-500">100</div>
                    </div>
                    <div
                        class="w-full bg-emerald-50 border-2 border-emerald-300 p-5 rounded-3xl flex items-center justify-between">
                        <div class="font-bold text-emerald-500">Transportasi Travel</div>
                        <div class="font-bold text-xl text-emerald-500">180</div>
                    </div>
                    <div
                        class="w-full bg-emerald-50 border-2 border-emerald-300 p-5 rounded-3xl flex items-center justify-between">
                        <div class="font-bold text-emerald-500">Rute Transportasi</div>
                        <div class="font-bold text-xl text-emerald-500">180</div>
                    </div>
                    <div
                        class="w-full bg-emerald-100 border-2 border-emerald-300 p-5 rounded-3xl flex items-center justify-between">
                        <div class="font-bold text-emerald-500">Transaksi</div>
                        <div class="font-bold text-xl text-emerald-500">100</div>
                    </div>
                </div>
                <div>
                    <div class="grid grid-cols-2 gap-5 mt-6">
                        <div class="bg-white p-5 rounded-3xl">
                            <div class="text-center font-bold mb-3">Distribusi Transportasi</div>
                            <canvas id="transportPieChart"></canvas>
                        </div>
                        <div class="bg-white p-5 rounded-3xl">
                            <div class="text-center font-bold mb-3">Top 5 Pelanggan Aktif</div>
                            <canvas id="topMemberChart"></canvas>
                        </div>
                    </div>
                </div>
            @endcan
            @can('role-A')
                <div>
                    <div class="bg-white p-5 rounded-3xl">
                        <div class="bg-gray-200 p-4 mb-4 rounded-3xl font-bold text-center">Grafik Peminat Rute Travel
                        </div>
                        <div class="chart-container">
                            <canvas id="travelChart" style="width: 900px; height: 200px;"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-3xl mt-4">
                        <div class="bg-gray-200 p-4 mb-4 rounded-3xl font-bold text-center">Grafik Transaksi Rental
                            Bulan Juni</div>
                        <div class="chart-container">
                            <canvas id="rentalChart" style="width: 900px; height: 200px;"></canvas>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // === Pie Chart: Distribusi Transportasi ===
        const transportData = {
            labels: ['Rental', 'Travel'],
            datasets: [{
                label: 'Distribusi Transportasi',
                data: [100, 180], // Ganti dengan data real dari backend jika ada
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 205, 86, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)'
                ],
                borderWidth: 1
            }]
        };

        const transportConfig = {
            type: 'pie',
            data: transportData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        };

        new Chart(
            document.getElementById('transportPieChart'),
            transportConfig
        );


        // === Bar Chart: Top 5 Pelanggan Aktif ===
        const memberData = {
            labels: ['Ali', 'Budi', 'Citra', 'Dian', 'Eka'], // Nama pelanggan
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [12, 10, 8, 6, 5], // Jumlah transaksi
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        };

        const memberConfig = {
            type: 'bar',
            data: memberData,
            options: {
                indexAxis: 'y', // Horizontal bar
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nama Pelanggan'
                        }
                    }
                }
            }
        };

        new Chart(
            document.getElementById('topMemberChart'),
            memberConfig
        );
    </script>

    <script>
        const rentalLabels = ['1 Juni', '2 Juni', '3 Juni', '4 Juni', '5 Juni', '6 Juni', '7 Juni'];
        const rentalData = {
            labels: rentalLabels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [5, 8, 6, 7, 10, 4, 9],
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 1
            }]
        };

        const rentalConfig = {
            type: 'bar',
            data: rentalData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('rentalChart'), rentalConfig);
    </script>

    <script>
        const routeLabels = [
            'BANJAR–BANDUNG',
            'BANJAR–JAKARTA',
            'BANJAR–GARUT',
            'BANJAR–CIAMIS',
            'BANJAR–YOGYAKARTA',
            'BANJAR–DEPOK',
            'BANJAR–BEKASI'
        ];

        const routeData = {
            labels: routeLabels,
            datasets: [{
                label: 'Jumlah Peminat per Rute',
                data: [120, 90, 75, 60, 45, 30, 25],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        };

        const routeConfig = {
            type: 'bar',
            data: routeData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Peminat'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Rute Perjalanan'
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('travelChart'), routeConfig);
    </script>


    </script>
    @php
        // untuk tooltip “Rp xxx” lebih rapih
        $fmt = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);
    @endphp
    <script>
        /* ambil data dari PHP/Blade */
        const labels = @json($labels); // contoh: ["Jun 01", "Jun 05", ...]
        const dataPoints = @json($dataPoints); // contoh: [250000, 500000, ...]

        const data = {
            labels,
            datasets: [{
                data: dataPoints,
                borderColor: '#22C55E',
                borderWidth: 2,
                pointRadius: ctx => ctx.dataIndex === dataPoints.length - 1 ? 6 : 0,
                pointBackgroundColor: '#22C55E',
                pointHoverRadius: 8,
                fill: true,
                tension: 0,
                backgroundColor: 'rgba(34, 197, 94, 0.05)'
            }]
        };

        const config = {
            type: 'line',
            data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            title: ctx => labels[ctx[0].dataIndex],
                            label: ctx => '{{ $fmt->getSymbol(\NumberFormatter::CURRENCY_SYMBOL) }}' + Intl
                                .NumberFormat('id-ID').format(ctx.raw)
                        },
                        filter: ctx => ctx.dataIndex === dataPoints.length - 1
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#999'
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: v => 'Rp' + (v / 1000).toLocaleString('id-ID') + 'k',
                            color: '#aaa'
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('balanceChart'), config);
    </script>
</x-app-layout>
