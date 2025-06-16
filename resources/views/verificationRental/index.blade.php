<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verifikasi Transaksi Rental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-start justify-between gap-5">
                <div class="bg-white px-12 pt-5 pb-6 rounded-3xl border shadow-xl w-full">
                    <div class="flex items-center gap-3 justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12"><img src="{{ url('/assets/img/data.png') }}" alt=""
                                    srcset="">
                            </div>
                            <div class="font-bold text-xl">Verifikasi Transaksi Rental</div>
                        </div>
                        <div class="flex items-center">
                        </div>
                    </div>
                    <hr class="mb-4 mt-3 border-2 rounded-xl">
                    <div class="flex justify-center">
                        <div class="p-0 " style="width:100%;overflow-x:auto;">
                            <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                                <div class="md:mt-0 sm:flex sm:space-x-4 w-full">
                                    <!-- Form untuk entries -->
                                    <x-show-entries :route="route('transactionsRental.index')" :search="request()->search">
                                    </x-show-entries>
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
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">MERK</th>
                                                <th scope="col" class="px-3 py-2 text-center">MODEL</th>
                                                <th scope="col" class="px-3 py-2 text-center">NOMOR POLISI</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">WAKTU
                                                    RENTAL</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">METODE
                                                    PEMBAYARAN</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">STATUS
                                                    PEMBAYARAN</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100">STATUS
                                                    RENTAL</th>
                                                <th scope="col" class="px-3 py-2 text-center bg-gray-100" hidden>QR
                                                    PEMBAYARAN</th>
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
                                                    @php
                                                        $today = \Carbon\Carbon::today();
                                                        $rentalEnd = \Carbon\Carbon::parse($i->rentalEndDate);
                                                        $diffInDays = $today->diffInDays($rentalEnd, false);
                                                        if ($rentalEnd->isSameDay($today)) {
                                                            $icon =
                                                                '<i class="fi fi-sr-cross-circle text-red-500" title="Waktu rental telah habis" onclick="return rentalStatus(' .
                                                                $i->id .
                                                                ')"></i>';
                                                        } elseif ($diffInDays === 2.0) {
                                                            $icon =
                                                                '<i class="fi fi-sr-octagon-exclamation text-amber-500" title="Waktu tersisa 3 hari"></i>';
                                                        } else {
                                                            $icon = '';
                                                        }
                                                    @endphp
                                                    <td class="px-3 py-2 text-center bg-gray-100">
                                                        {!! $icon !!} {{ $i->member->name }}
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        {{ $i->transportationRental->transportation->transportation }}
                                                    </td>
                                                    <td class="px-3 py-2 text-center bg-gray-100">
                                                        {{ $i->transportationRental->merk->merk }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        {{ $i->transportationRental->model }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        {{ $i->transportationRental->license_plate }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        {{ date('d-m-Y', strtotime($i->rentalStartDate)) }} <span
                                                            class="font-bold text-red-500">s/d</span>
                                                        {{ date('d-m-Y', strtotime($i->rentalEndDate)) }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        {{ $i->paymentMethod }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        {{ $i->paymentStatus }}</td>
                                                    @php
                                                        if ($i->rentalStatus === 'SELESAI') {
                                                            $bg = 'sky';
                                                        } elseif ($i->rentalStatus === 'RENTAL') {
                                                            $bg = 'amber';
                                                        } else {
                                                            $bg = 'red';
                                                        }
                                                    @endphp
                                                    <td class="px-3 py-2 text-center">
                                                        <span
                                                            class="bg-{{ $bg }}-100 px-4 text-{{ $bg }}-500 border border-{{ $bg }}-500 rounded-xl">{{ $i->rentalStatus }}</span>
                                                    </td>
                                                    <td class="px-3 py-2 text-center hidden">
                                                        <button type="button"
                                                            onclick="pembayaran('{{ $i->id }}', '{{ $i->created_at->toIso8601String() }}', '{{ $i->proofOfPayment }}')">BAYAR</button>
                                                    </td>

                                                    <div id="modal-{{ $i->id }}"
                                                        class="hidden fixed inset-0 flex justify-center items-center z-50">
                                                        <div
                                                            class="absolute inset-0 bg-black opacity-50 backdrop-blur-sm">
                                                        </div>

                                                        <div
                                                            class="bg-white rounded-lg p-6 lg:w-4/12 w-full shadow-xl z-10">
                                                            <div class="flex">
                                                                <div>
                                                                    <h2 class="text-lg font-bold mb-4 p-2 rounded-xl">
                                                                        Verifikasi Rental</h2>
                                                                </div>
                                                            </div>

                                                            <hr class="border mb-5 border-black border-opacity-30">

                                                            <form id="payment-form"
                                                                action="{{ route('verificationRental.update', $i->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mt-3 justify-center">
                                                                    <div class="mb-5 mt-5">
                                                                        Apakah anda yakin untuk verifikasi transaksi rental? cek kelengkapan dan surat kendaraan!
                                                                    </div>
                                                                    <hr
                                                                        class="border mb-5 border-black border-opacity-30">
                                                                    <div class="flex justify-end gap-2">
                                                                        <button type="submit"
                                                                            class="bg-sky-500 text-white px-4 py-2 rounded">Ok</button>
                                                                        <button type="button"
                                                                            onclick="closeModal({{ $i->id }})"
                                                                            class="bg-red-500 text-white px-4 py-2 rounded">Tutup</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

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
            </div>
        </div>
    </div>
    <script>
        function rentalStatus(id) {
            const modal = document.getElementById(`modal-${id}`);
            if (modal) {
                modal.classList.remove("hidden");
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(`modal-${id}`);
            if (modal) {
                modal.classList.add("hidden");
            }
        }
    </script>
</x-app-layout>
