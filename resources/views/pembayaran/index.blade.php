<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Merk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="items-start justify-between gap-5 bg-white px-4 pt-2 pb-[2px] rounded-2xl shadow-md">
                <div class="font-extrabold text-xl mb-2 text-center">TRANSACTION FOR PAYMENT</div>
                @php
                    if ($data->paymentStatus === 'WAITING FOR PAYMENT') {
                        $color = 'amber';
                        $text = 'Harap melakukan pembayaran sebelum waktu habis!';
                    } else if($data->paymentStatus === 'SUCCESS'){
                        $color = 'emerald';
                        $text = 'Selamat! pembayaranmu sudah berhasil diproses ✅';
                    }else {
                        $color = 'red';
                        $text = 'Maaf, waktu untuk melakukan pembayaran sudah melewati batas! 🙏';
                    }
                @endphp
                <div
                    class="bg-{{ $color }}-50 border border-{{ $color }}-500 px-4 py-2 text-{{ $color }}-500 rounded-2xl">
                    {{ $text }}
                </div>
                <div class="mt-3 mb-5">
                    <div class="font-extrabold text-2xl">{{ $data->transportationRental->merk->merk }} -
                        {{ $data->transportationRental->model }}</div>
                    <div class="mt-2">
                        <div class="flex gap-12">
                            <div><img src="{{ asset('rental/car/' . $data->transportationRental->photo_right) }}"
                                    class="rounded-3xl"></div>
                            <div>
                                <table>
                                    <tr>
                                        <td class="font-bold">Nomor Polisi</td>
                                        <td class="w-10 text-center">:</td>
                                        <td>{{ $data->transportationRental->license_plate }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">Bahan Bakar</td>
                                        <td class="w-10 text-center">:</td>
                                        <td>{{ $data->transportationRental->fuel_type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">Harga Rental</td>
                                        <td class="w-10 text-center">:</td>
                                        <td>Rp {{ number_format($data->transportationRental->rental_price) }} / Hari
                                        </td>
                                    </tr>
                                    @php
                                        if ($data->paymentStatus === 'SUCCESS') {
                                            $bg = 'sky';
                                            $text = 'Sukses';
                                        } elseif ($data->paymentStatus === 'CANCEL') {
                                            $bg = 'red';
                                            $text = 'Gagal';
                                        } else {
                                            $bg = 'amber';
                                            $text = 'Belum dibayar';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="font-bold">Status Pembayaran</td>
                                        <td class="w-10 text-center">:</td>
                                        <td>
                                            <div
                                                class="bg-{{ $bg }}-100 text-{{ $bg }}-500 px-4 rounded-3xl text-center">
                                                {{ $text }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">Metode Pembayaran</td>
                                        <td class="w-10 text-center">:</td>
                                        <td>{{ $data->paymentMethod }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold">Total Bayar</td>
                                        <td class="w-10 text-center">:</td>
                                        <td>Rp {{ number_format($data->rentalCost) }}</td>
                                    </tr>
                                </table>
                                @if ($data->paymentStatus === 'SUCCESS')
                                    <div class="bg-sky-100 text-center mt-4 py-2 text-sky-500 cursor-pointer"
                                        onclick="return faktur()">
                                        Download Faktur
                                    </div>
                                @else
                                    <hr class="mt-2">
                                    <div class="font-bold text-center">Sisa Waktu Pembayaran</div>
                                    <div id="countdown" class="font-bold text-red-500 text-center">--:--</div>
                                    <hr>
                                    <div class="mt-2 flex gap-5 items-center justify-start">
                                        <div class="text-center">
                                            <div class="font-bold">QR Pembayaran</div>
                                            <div class="w-24" id="qris-container">
                                                <img src="{{ asset('qris/qris.png') }}" id="qrisImage">
                                            </div>
                                        </div>
                                        <div id="bukti-btn"
                                            class="text-center bg-sky-50 border border-sky-500 text-sky-500 hover:bg-sky-200 ml-8 px-4 py-2 rounded-3xl cursor-pointer"
                                            onclick="return bukti()">
                                            Bukti Pembayaran
                                        </div>
                                        <div id="bukti-btn-habis"
                                            class="text-center bg-red-50 border border-red-500 text-red-500 hover:bg-red-200 ml-8 px-4 py-2 rounded-3xl cursor-pointer hidden">
                                            Waktu Habis
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
    <div id="modal" class="hidden fixed inset-0 flex justify-center items-center z-50">
        <!-- Backdrop Blur -->
        <div class="absolute inset-0 bg-black opacity-50 backdrop-blur-sm"></div>

        <div class="bg-white rounded-lg p-6 lg:w-4/12 w-full shadow-xl z-10">
            <div class="flex">
                <div>
                    <h2 class="text-lg font-bold mb-4 p-2 rounded-xl">Upload Bukti Pembayaran</h2>
                </div>
            </div>

            <hr class="border mb-5 border-black border-opacity-30">

            <form id="payment-form" action="{{ route('transactionsRental.updatePembayaran', $data->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mt-3 justify-center">
                    <div class="mb-5 mt-5">
                        <input type="file" name="proof_of_payment" id="proof_of_payment"
                            class="w-full border border-gray-300 rounded-3xl px-4" required>
                        <p id="error-proof_of_payment" class="mt-2 text-sm text-red-500 hidden">Bukti pembayaran wajib
                            diisi.</p>
                    </div>
                    <hr class="border mb-5 border-black border-opacity-30">
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal()"
                            class="bg-red-500 text-white px-4 py-2 rounded">Tutup</button>
                        <button type="submit" class="bg-sky-500 text-white px-4 py-2 rounded">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="modalFaktur" class="hidden fixed inset-0 flex justify-center items-center z-50">
        <!-- Backdrop Blur -->
        <div class="absolute inset-0 bg-black opacity-50 backdrop-blur-sm"></div>

        <div class="bg-white rounded-lg p-6 lg:w-4/12 w-full shadow-xl z-10">
            <div class="px-4" id="content-faktur">
                <div class="text-center">
                    <div class="flex justify-center"><img src="/assets/img/data.png" alt="" class="w-16">
                    </div>
                    <div class="font-bold text-lg">Faktur Pembayaran Rental</div>
                    <div class="text-xs">Jalan mana aja yang penting jalan</div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between">
                        <div>
                            <table>
                                <tr>
                                    <td class="font-bold">{{ $data->member->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table>
                                <tr>
                                    <td>Tanggal Transaksi</td>
                                    <td class="px-2">:</td>
                                    <td class="font-bold">{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="flex gap-5 mt-3">
                        <div>
                            <div class="font-bold">Unit</div>
                            <hr>
                            <div>
                                <table>
                                    <tr>
                                        <td>Merk</td>
                                        <td class="px-4">:</td>
                                        <td>{{ $data->transportationRental->merk->merk }}</td>
                                    </tr>
                                    <tr>
                                        <td>Model</td>
                                        <td class="px-4">:</td>
                                        <td>{{ $data->transportationRental->model }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bahan Bakar</td>
                                        <td class="px-4">:</td>
                                        <td>{{ $data->transportationRental->fuel_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>Harga</td>
                                        <td class="px-4">:</td>
                                        <td>{{ number_format($data->transportationRental->rental_price) }}/Hari</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold">Driver</div>
                            <hr>
                            <div>
                                <table>
                                    <tr>
                                        <td>Driver</td>
                                        <td class="px-4">:</td>
                                        <td>{{ $data->driver->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Harga Driver</td>
                                        <td class="px-4">:</td>
                                        <td>{{ $data->driver && $data->driver->prices ? number_format($data->driver->prices) : 0 }}/Hari
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <table class="mt-3 border-collapse border border-gray-400 w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-3 py-2 text-center">Tanggal</th>
                                <th class="border border-gray-300 px-3 py-2 text-center">Jumlah Hari</th>
                                <th class="border border-gray-300 px-3 py-2 text-center">Total Bayar</th>
                                <th class="border border-gray-300 px-3 py-2 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $start = \Carbon\Carbon::parse($data->rentalStartDate);
                                $end = \Carbon\Carbon::parse($data->rentalEndDate);
                                $duration = $start->diffInDays($end) + 1;
                            @endphp
                            <tr>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ $start->format('d-m-Y') }} - {{ $end->format('d-m-Y') }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    {{ $duration }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    Rp {{ number_format($data->rentalCost, 0, ',', '.') }}
                                </td>
                                <td class="border border-gray-300 px-3 py-2 text-center">
                                    SUCCESS
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center flex justify-center">
                        <svg id="barcode"></svg>
                    </div>
                </div>
            </div>
            <div class="mt-3 justify-center">
                <hr class="border mb-5 border-black border-opacity-30">
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModalFaktur()"
                        class="bg-red-500 text-white px-4 py-2 rounded">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function bukti() {
            const modalContent = document.getElementById("modal-content");
            const modal = document.getElementById("modal");
            modal.classList.remove("hidden");
        }

        function closeModal() {
            const modal = document.getElementById("modal");
            modal.classList.add("hidden");
        }

        function faktur() {
            const modalContent = document.getElementById("modal-contentFaktur");
            const modal = document.getElementById("modalFaktur");
            modal.classList.remove("hidden");

            // Tunggu sedikit agar modal muncul sempurna
            setTimeout(() => {
                const fakturEl = document.getElementById("content-faktur");

                html2canvas(fakturEl).then(canvas => {
                    const link = document.createElement("a");
                    link.download = "faktur-pembayaran.png";
                    link.href = canvas.toDataURL("image/png");
                    link.click();
                });
            }, 500); // beri jeda 0.5 detik biar modal sempat render
        }

        function closeModalFaktur() {
            const modal = document.getElementById("modalFaktur");
            modal.classList.add("hidden");
        }
    </script>
    <script>
        const createdAt = new Date("{{ $data->created_at }}");
        const paymentDeadline = new Date(createdAt.getTime() + 6 * 60000); // 6 menit
        const countdownEl = document.getElementById("countdown");
        const qrisImages = document.getElementById("qris-image");
        const buktiBtn = document.getElementById("bukti-btn");
        const buktiBtnHabis = document.getElementById("bukti-btn-habis");
        const qrisImage = document.getElementById('qrisImage');

        function updateCountdown() {
            const now = new Date();
            const diff = paymentDeadline - now;

            if (diff <= 0) {
                countdownEl.innerText = "00:00";
                clearInterval(interval);

                if (countdown.textContent.trim() === '00:00') {
                    qrisImage.classList.add('blur-sm');
                    buktiBtn.classList.add('hidden');
                    buktiBtnHabis.classList.remove('hidden');
                } else {
                    qrisImage.classList.remove('blur-sm');
                    buktiBtn.classList.remove('hidden');
                    buktiBtnHabis.classList.add('hidden');
                }
                return;
            }

            const minutes = String(Math.floor(diff / 60000)).padStart(2, '0');
            const seconds = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            countdownEl.innerText = `${minutes}:${seconds}`;
        }

        const interval = setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            JsBarcode("#barcode", "{{ $data->codeTransaction }}", {
                format: "CODE128",
                lineColor: "#000",
                width: 2,
                height: 60,
                displayValue: false // set true kalau mau kode ditampilkan juga di bawah barcode
            });
        });
    </script>

</x-app-layout>
