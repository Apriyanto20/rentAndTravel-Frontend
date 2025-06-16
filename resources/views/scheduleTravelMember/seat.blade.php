<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Seat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="items-start justify-between gap-5">
                <div class="flex justify-center items-center text-center mb-3">
                    BAGIAN DEPAN
                </div>
                <hr class="border-gray-400 w-full mb-4">
                <div>
                    @foreach ($data as $d)
                        <div class="grid grid-cols-2 gap-1" id="seats">
                            {{-- @foreach ($d->detailTransportation->detailSeats as $seat)
                                <div
                                    class="bg-sky-500 w-16 h-16 text-white text-center flex items-center justify-center mb-5">
                                </div>
                            @endforeach --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div id="modal" class="hidden fixed inset-0 flex justify-center items-center m-4">
        <div class="bg-white rounded-lg p-6 lg:w-4/12 w-full shadow-xl">
            <h2 class="text-lg font-bold mb-4 bg-amber-100 p-2 rounded-xl">Pesan Ruangan</h2>
            <form id="bookingForm" action="{{ route('transportationTravelMember.store') }}" method="post"
                class="w-full">
                <p id="modal-content"></p>
                <button type="submit" id="submitBooking" class="mt-4 bg-sky-500 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <button type="button" onclick="closeModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Tutup</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>
    <script>
        function updateSeat(codeSchedule, id, routePrice) {
            const modalContent = document.getElementById("modal-content");
            const pemesananStoreUrl = "{{ route('transportationTravelMember.store') }}";
            modalContent.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="${codeSchedule}">
                    <input type="hidden" name="seatCode" value="${id}">
                    <input type="hidden" value="${routePrice}" name="routePrice">
                    <div class="lg:mb-5 mb-2 w-full">
                        <label for="paymentMethod" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Kuliah <span class="text-red-500">*</span></label>
                        <select id="paymentMethod" class="js-example-placeholder-single js-states lg:w-[387px] w-[280px] form-control m-6" name="paymentMethod" data-placeholder="Pilih Metode Pembayaran">
                            <option value="">Pilih...</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                        <p id="error-paymentMethod" class="mt-2 text-sm text-red-500 hidden">Mata kuliah wajib dipilih.</p>
                    </div>
            `;

            // Tampilkan modal
            initializeSelect2();
            const modal = document.getElementById("modal");
            modal.classList.remove("hidden");
        }

        // Fungsi untuk menginisialisasi Select2
        const initializeSelect2 = () => {
            $('.js-example-placeholder-single').select2({
                placeholder: "Pilih...",
                allowClear: true,
            });
        };

        function closeModal() {
            const modal = document.getElementById("modal");
            modal.classList.add("hidden");
        }
    </script>
    <script>
        const socket = io("http://localhost:3000");
        socket.on("connect", () => {
            console.log("connected");
        });
        socket.on("connect_error", () => {
            console.log("not connected");
        });
        socket.on("seats", (data) => {
            let SeatContent = "";
            for (let i = 0; i < data.length; i++) {
                SeatContent += `
                    <div
                        class="${
                            data[i].statusSeat === 'ACTIVE' || data[i].statusSeat === 'WAITING'
                                ? 'bg-sky-500 text-white cursor-pointer'
                                : 'bg-gray-300 text-black cursor-not-allowed'
                        } w-16 h-16 text-center flex items-center justify-center mb-5"
                        ${
                            data[i].statusSeat === 'ACTIVE' || data[i].statusSeat === 'WAITING'
                                ? `onclick="updateSeat('${data[i].codeSchedule}', '${data[i].seatCode}', '${data[i].routePrice}')"`
                                : ''
                        }
                    >
                        ${data[i].seatCode}
                    </div>
                `;
            }
            document.getElementById("seats").innerHTML = SeatContent;
            console.log(data);
        });

        function getSeat() {
            socket.emit("getSeat", true);
        }
        getSeat();
    </script>
</x-app-layout>
