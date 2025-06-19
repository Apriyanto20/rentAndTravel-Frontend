<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Seat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="items-start justify-between gap-5">
                @foreach ($data as $d)
                    @php
                        $onclick = '';

                        if ($d->paymentStatus === 'WAITING') {
                            $onclick = "onclick=\"return openPaymentModal('{$d->id}')\"";
                        } elseif ($d->paymentStatus === 'SUCCESS') {
                            $onclick = "onclick=\"return openFakturModal('{$d->id}')\"";
                        }
                    @endphp
                    <div class="flex cursor-pointer mb-4" {!! $onclick !!}>
                        <div class="h-8 w-[20px] bg-[#F3F4F6] rounded-r-full mt-36 -mr-[19px] z-10 border border-l-0">
                        </div>
                        <div class="p-4 rounded-3xl border bg-white h-64 w-full">
                            @php
                                if ($d->paymentStatus === 'CANCEL') {
                                    $bg = 'red';
                                } elseif ($d->paymentStatus === 'WAITING') {
                                    $bg = 'amber';
                                } elseif ($d->paymentStatus === 'SUCCESS') {
                                    $bg = 'sky';
                                }
                            @endphp
                            <div
                                class="bg-{{ $bg }}-500 text-white w-56 text-center flex items-center justify-center ml-44 -mt-4 p-2 rounded-b-2xl font-bold">
                                {{ $d->paymentStatus }}
                            </div>
                            <div class="flex justify-between -mt-4 px-10">
                                <div>
                                    <div class="font-[900] text-[35px]">
                                        {{ \App\Models\TransactionsTravel::singkat(trim(Str::before($d->schedule->route->route, '-'))) }}
                                    </div>
                                    <div class="font-bold text-gray-400 -mt-2">
                                        {{ trim(Str::before($d->schedule->route->route, '-')) }}</div>
                                </div>
                                <div>
                                    <div class="font-[900] text-[35px]">
                                        {{ \App\Models\TransactionsTravel::singkat(trim(Str::after($d->schedule->route->route, '-'))) }}
                                    </div>
                                    <div class="font-bold text-gray-400 -mt-2">
                                        {{ trim(Str::after($d->schedule->route->route, '-')) }}</div>
                                </div>
                            </div>
                            <div class="px-10 flex justify-between items-center mt-2">
                                <div>
                                    <div class="text-gray-400 text-lg">Date</div>
                                    <div class="font-bold text-xl -mt-2">{{ date('d F', strtotime($d->tgl_berangkat)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-gray-400 text-lg">Year</div>
                                    <div class="font-bold text-xl -mt-2">{{ date('Y', strtotime($d->tgl_berangkat)) }}
                                    </div>
                                </div>
                            </div>
                            <hr class="border border-dashed mt-[10px] ml-1">
                            <div class="flex items-center px-10 justify-between">
                                <div class="flex">
                                    <div
                                        class="bg-{{ $bg }}-500 text-white w-10 h-10 flex items-center justify-center rounded-full pt-1 mt-5">
                                        <i class="fi fi-bs-car"></i>
                                    </div>
                                    <div class="font-bold mt-6 ml-2 text-2xl">{{ $d->schedule->route->route }}</div>
                                </div>
                                <div class="font-bold mt-6 ml-2 text-2xl">
                                    Rp {{ number_format($d->price) }}
                                </div>
                            </div>
                        </div>
                        <div class="h-8 w-[20px] bg-[#F3F4F6] rounded-l-full mt-36 -ml-[20px] z-10 border border-r-0">
                        </div>
                    </div>
                    <div id="modal-{{ $d->id }}"
                        class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50">
                        <div class="bg-white p-6 rounded-2xl w-full max-w-md relative">
                            <button onclick="closePaymentModal('{{ $d->id }}')"
                                class="absolute top-2 right-4 text-gray-400 hover:text-black text-2xl">&times;</button>
                            <h2 class="text-xl font-bold mb-4">Konfirmasi Pembayaran</h2>
                            <form method="POST" action="{{ route('transactionTravelMember.update', $d->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="transaction_id" value="{{ $d->id }}">
                                <div class="flex">
                                    <div class="h-12 w-10 bg-white rounded-r-full -mr-5 z-10 mt-16"></div>
                                    <div class="bg-[#F3F4F6] h-96 rounded-3xl w-full">
                                        <div class="flex items-center px-8 justify-between">
                                            <div class="flex">
                                                <div
                                                    class="bg-{{ $bg }}-500 text-white w-10 h-10 flex items-center justify-center rounded-full pt-1 mt-5">
                                                    <i class="fi fi-bs-car"></i>
                                                </div>
                                                <div class="font-bold mt-7 ml-2">
                                                    {{ $d->schedule->route->route }}</div>
                                            </div>
                                            <div class="font-bold mt-5 ml-2">
                                                Rp {{ number_format($d->price) }}
                                            </div>
                                        </div>
                                        <hr class="border border-dashed mt-[24px] ml-1 border-white">
                                        <div class="flex px-8 mt-4 justify-between">
                                            <div>
                                                <div>
                                                    {{ \App\Models\TransactionsTravel::singkat(trim(Str::before($d->schedule->route->route, '-'))) }}
                                                </div>
                                                <div>{{ trim(Str::before($d->schedule->route->route, '-')) }}</div>
                                            </div>
                                            <div class="w-24 flex items-center justify-center">
                                                <div
                                                    class="h-2 w-2 bg-amber-500 rounded-full flex items-center justify-center">
                                                    <div class="h-1 w-1 bg-white rounded-full"></div>
                                                </div>
                                                <div class="w-full">
                                                    <hr class="border-dashed border-amber-500">
                                                </div>
                                                <div
                                                    class="h-2 w-2 bg-amber-500 rounded-full flex items-center justify-center">
                                                    <div class="h-1 w-1 bg-white rounded-full"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    {{ \App\Models\TransactionsTravel::singkat(trim(Str::after($d->schedule->route->route, '-'))) }}
                                                </div>
                                                <div>{{ trim(Str::after($d->schedule->route->route, '-')) }}</div>
                                            </div>
                                        </div>
                                        <hr class="my-2 mx-4">
                                        <div class="flex px-8">
                                            <div
                                                class="w-12 h-12 rounded-full bg-black flex items-center justify-center">
                                                <img src="{{ url('/member/img/', $photo) }}"
                                                    class="w-10 rounded-full bg-white">
                                            </div>
                                            <div class="ml-2 mt-2">
                                                <div class="font-[1000] text-xs">
                                                    {{ strlen($member->name) > 15 ? Str::words($member->name, 2, '') : $member->name }}
                                                </div>
                                                <div class="text-gray-400 text-sm">nabila@gmail.com</div>
                                            </div>
                                            <div class="ml-20 text-right mt-1">
                                                <div class="text-gray-400 text-sm font-bold">Seat</div>
                                                <div class="font-extrabold text-xs">{{ $d->seat_code }}</div>
                                            </div>
                                        </div>
                                        <hr class="my-2 mx-4">
                                        <div class="flex px-8 justify-between mt-2">
                                            <div>
                                                <div class="text-gray-400 text-sm font-bold">Date</div>
                                                <div class="font-extrabold text-xs">
                                                    {{ date('d F', strtotime($d->tgl_berangkat)) }}</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-400 text-sm font-bold">Year</div>
                                                <div class="font-extrabold text-xs">
                                                    {{ date('Y', strtotime($d->tgl_berangkat)) }}</div>
                                            </div>
                                        </div>
                                        <hr class="my-2 mx-4">
                                        <div class="flex justify-between items-center mt-3 px-8">
                                            <div class="w-1/2">
                                                <img src="{{ asset('qris/qris.png') }}" class="w-20 h-20">
                                            </div>
                                            <div class="w-full">
                                                <div class="text-sm font-bold">Upload Bukti Bayar</div>
                                                <input type="file" name="proof_of_payment" id="proof_of_payment"
                                                    class="text-xs border border-gray-300 rounded-xl px-2 py-[3px] w-full file:mr-2 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-12 w-10 bg-white rounded-l-full -ml-5 z-10 mt-16"></div>
                                </div>
                                <div class="flex justify-end gap-3 mt-6">
                                    <button type="button" onclick="closePaymentModal('{{ $d->id }}')"
                                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">Batal</button>
                                    <button type="submit"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Bayar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="modal-{{ $d->id }}-faktur"
                        class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50">
                        <div class="bg-white p-6 rounded-2xl w-full max-w-md relative">
                            <button onclick="closePaymentModalFaktur('{{ $d->id }}')"
                                class="absolute top-2 right-4 text-gray-400 hover:text-black text-2xl">&times;</button>
                            <h2 class="text-xl font-bold mb-4">Faktur Pembayaran</h2>
                            <form method="POST" action="#">
                                <input type="hidden" name="transaction_id" value="{{ $d->id }}">
                                <div class="flex" id="faktur-{{ $d->id }}">
                                    <div class="h-12 w-10 bg-white rounded-r-full -mr-5 z-10 mt-16"></div>
                                    <div class="bg-[#F3F4F6] h-96 rounded-3xl w-full">
                                        <div class="flex items-center px-8 justify-between">
                                            <div class="flex">
                                                <div
                                                    class="bg-{{ $bg }}-500 text-white w-10 h-10 flex items-center justify-center rounded-full pt-1 mt-5">
                                                    <i class="fi fi-bs-car"></i>
                                                </div>
                                                <div class="font-bold mt-7 ml-2">
                                                    {{ $d->schedule->route->route }}</div>
                                            </div>
                                            <div class="font-bold mt-5 ml-2">
                                                Rp {{ number_format($d->price) }}
                                            </div>
                                        </div>
                                        <hr class="border border-dashed mt-[24px] ml-1 border-white">
                                        <div class="flex px-8 mt-4 justify-between">
                                            <div>
                                                <div>
                                                    {{ \App\Models\TransactionsTravel::singkat(trim(Str::before($d->schedule->route->route, '-'))) }}
                                                </div>
                                                <div>{{ trim(Str::before($d->schedule->route->route, '-')) }}</div>
                                            </div>
                                            <div class="w-24 flex items-center justify-center">
                                                <div
                                                    class="h-2 w-2 bg-amber-500 rounded-full flex items-center justify-center">
                                                    <div class="h-1 w-1 bg-white rounded-full"></div>
                                                </div>
                                                <div class="w-full">
                                                    <hr class="border-dashed border-amber-500">
                                                </div>
                                                <div
                                                    class="h-2 w-2 bg-amber-500 rounded-full flex items-center justify-center">
                                                    <div class="h-1 w-1 bg-white rounded-full"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    {{ \App\Models\TransactionsTravel::singkat(trim(Str::after($d->schedule->route->route, '-'))) }}
                                                </div>
                                                <div>{{ trim(Str::after($d->schedule->route->route, '-')) }}</div>
                                            </div>
                                        </div>
                                        <hr class="my-2 mx-4">
                                        <div class="flex px-8">
                                            <div
                                                class="w-12 h-12 rounded-full bg-black flex items-center justify-center">
                                                <img src="{{ url('/member/img/', $photo) }}"
                                                    class="w-10 rounded-full bg-white">
                                            </div>
                                            <div class="ml-2 mt-2">
                                                <div class="font-[1000] text-xs">
                                                    {{ strlen($member->name) > 15 ? Str::words($member->name, 2, '') : $member->name }}
                                                </div>
                                                <div class="text-gray-400 text-sm">nabila@gmail.com</div>
                                            </div>
                                            <div class="ml-20 text-right mt-1">
                                                <div class="text-gray-400 text-sm font-bold">Seat</div>
                                                <div class="font-extrabold text-xs">{{ $d->seat_code }}</div>
                                            </div>
                                        </div>
                                        <hr class="my-2 mx-4">
                                        <div class="flex px-8 justify-between mt-2">
                                            <div>
                                                <div class="text-gray-400 text-sm font-bold">Date</div>
                                                <div class="font-extrabold text-xs">
                                                    {{ date('d F', strtotime($d->tgl_berangkat)) }}</div>
                                            </div>
                                            <div>
                                                <div class="text-gray-400 text-sm font-bold">Year</div>
                                                <div class="font-extrabold text-xs">
                                                    {{ date('Y', strtotime($d->tgl_berangkat)) }}</div>
                                            </div>
                                        </div>
                                        <hr class="my-2 mx-4">
                                        <div class="flex justify-between items-center mt-3 px-8">
                                            <div class="w-1/2">
                                                <div id="qrcode-{{ $d->id }}" class="rounded-xl p-1">
                                                </div>
                                                <script>
                                                    window.addEventListener('load', () => {
                                                        new QRCode("qrcode-{{ $d->id }}", {
                                                            text: "{{ $d->id }}{{ $d->tgl_berangkat }}{{ $d->seat_code }}{{ $d->member->nik ?? '' }}",
                                                            width: 64,
                                                            height: 64
                                                        });
                                                    });
                                                </script>
                                            </div>
                                            <div class="w-full">
                                                <div class="text-sm">
                                                    Terima Kasih Sudah Menggunakan Jasa Travel Kami!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-12 w-10 bg-white rounded-l-full -ml-5 z-10 mt-16"></div>
                                </div>
                                <div class="flex justify-end gap-3 mt-6">
                                    <button type="button" onclick="closePaymentModalFaktur('{{ $d->id }}')"
                                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">Batal</button>
                                    <button type="button"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                                        onclick="downloadFaktur('{{ $d->id }}')">Download</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadFaktur(id) {
            const element = document.getElementById('faktur-' + id);
            if (!element) return;

            html2canvas(element).then(canvas => {
                const link = document.createElement('a');
                link.download = 'faktur_' + id + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>
    <script>
        function openPaymentModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
            document.getElementById('modal-' + id).classList.add('flex');
            return false;
        }

        function closePaymentModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
            document.getElementById('modal-' + id).classList.remove('flex');
        }

        function openFakturModal(id) {
            document.getElementById('modal-' + id + '-faktur').classList.remove('hidden');
            document.getElementById('modal-' + id + '-faktur').classList.add('flex');
            return false;
        }

        function closePaymentModalFaktur(id) {
            document.getElementById('modal-' + id + '-faktur').classList.add('hidden');
            document.getElementById('modal-' + id + '-faktur').classList.remove('flex');
        }
    </script>
</x-app-layout>
