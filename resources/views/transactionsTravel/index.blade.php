<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-start justify-between gap-5">
                <div class="bg-white px-12 pt-5 pb-6 rounded-3xl border shadow-xl w-full">
                    <div class="flex items-center gap-3 justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12"><img src="{{ url('/assets/img/data.png') }}" alt=""></div>
                            <div class="font-bold text-xl">Transportasi Rental</div>
                        </div>
                    </div>
                    <hr class="mb-4 mt-3 border-2 rounded-xl">

                    <div class="flex justify-center">
                        <div class="p-0" style="width:100%;overflow-x:auto;">
                            <div class="relative overflow-x-auto rounded-lg shadow-lg">
                                <table class="table-auto w-full text-sm text-left text-gray-500 border">
                                    <thead class="text-md font-bold text-gray-700 uppercase">
                                        <tr>
                                            <th class="px-3 py-2 text-center">NO</th>
                                            <th class="px-3 py-2 text-center bg-gray-100">WAKTU TRANSAKSI</th>
                                            <th class="px-3 py-2 text-center bg-gray-100">MEMBER KODE</th>
                                            <th class="px-3 py-2 text-center bg-gray-100">MEMBER</th>
                                            <th class="px-3 py-2 text-center">KODE SEAT</th>
                                            <th class="px-3 py-2 text-center bg-gray-100">HARGA</th>
                                            <th class="px-3 py-2 text-center bg-gray-100">METODE PEMBAYARAN</th>
                                            <th class="px-3 py-2 text-center bg-gray-100">STATUS PEMBAYARAN</th>
                                            <th class="px-3 py-2 text-center bg-gray-100">WAKTU PEMBAYARAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = $transactionsTravel->firstItem(); @endphp
                                        @forelse($transactionsTravel as $i)
                                            <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700"
                                                data-id="{{ $i->id }}"
                                                data-expired-at="{{ \Carbon\Carbon::parse($i->created_at)->addMinutes(5)->format('Y-m-d\TH:i:s') }}"
                                                data-proof="{{ $i->proofOfPayment }}">
                                                <td class="px-3 py-2 text-center">{{ $no++ }}</td>
                                                <td class="px-3 py-2 text-center">{{ $i->created_at }}</td>
                                                <td class="px-3 py-2 text-center bg-gray-100">{{ $i->member->nik }}</td>
                                                <td class="px-3 py-2 text-center bg-gray-100">{{ $i->member->name }}</td>
                                                <td class="px-3 py-2 text-center">{{ $i->seat_code }}</td>
                                                <td class="px-3 py-2 text-center bg-gray-100">{{ $i->price }}</td>
                                                <td class="px-3 py-2 text-center">{{ $i->paymentMethod }}</td>
                                                <td class="px-3 py-2 text-center">{{ $i->paymentStatus }}</td>
                                                <td class="px-3 py-2 text-center time-left"></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="px-3 py-2 text-center bg-gray-500 text-white">
                                                    Data Belum Tersedia!
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                @if ($transactionsTravel->hasPages())
                                    {{ $transactionsTravel->appends(request()->query())->links('vendor.pagination.custom') }}
                                @else
                                    <div class="flex items-center justify-between">
                                        <nav class="flex justify-start">
                                            <div class="text-sm flex gap-1">
                                                <div>Showing</div>
                                                <div class="font-bold">1</div>
                                                <div>to</div>
                                                <div class="font-bold">{{ count($transactionsTravel) }}</div>
                                                <div>of</div>
                                                <div class="font-bold">{{ count($transactionsTravel) }}</div>
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
            </div>
        </div>
    </div>

    {{-- Reload tiap 1 menit --}}
    <script>
        setInterval(() => {
            location.reload();
        }, 60000);
    </script>

    {{-- Update countdown & batalkan otomatis --}}
    <script>
        function updateCountdowns() {
            const rows = document.querySelectorAll('tr[data-expired-at]');
            const now = new Date();

            rows.forEach(row => {
                const expiredAt = new Date(row.dataset.expiredAt);
                const proof = row.dataset.proof;
                const timeCell = row.querySelector('.time-left');

                const diffMs = expiredAt - now;

                if (diffMs > 0) {
                    const minutes = Math.floor(diffMs / 60000);
                    const seconds = Math.floor((diffMs % 60000) / 1000);
                    timeCell.textContent = `${minutes} menit ${seconds} detik lagi`;
                } else {
                    timeCell.textContent = 'Waktu habis';

                    if (proof === "") {
                        const id = row.dataset.id;
                        // Cegah pengiriman berulang
                        if (!row.dataset.cancelled) {
                            row.dataset.cancelled = true;

                            fetch(`/transactionsTravel/cancel/${id}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    row.querySelector('td:nth-child(8)').textContent = 'CANCEL';
                                }
                            });
                        }
                    }
                }
            });
        }

        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
</x-app-layout>
