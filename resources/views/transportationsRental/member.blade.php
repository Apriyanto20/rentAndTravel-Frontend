<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Merk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="items-start justify-between gap-5">
                <div class="flex justify-between items-center">
                    <div class="mb-6 flex">
                        <div class="py-2 bg-black px-4 border border-black-400 text-white rounded-l-xl cursor-pointer"
                            onclick="toggleModal('filterModal')">Short by Available
                        </div>
                        <div class="py-2 px-4 border border-black-400 text-black-400 rounded-r-xl font-bold cursor-pointer"
                            onclick="toggleModal('filterModalMerk')">
                            Short by
                            Merk</div>
                    </div>
                    <div class="mb-6 flex">
                        <form action="{{ route('transportationRentalMember.index') }}" method="GET"
                            class="flex items-center gap-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="bg-gray-200 border border-gray-200 rounded-2xl w-96 px-4 py-2"
                                placeholder="Search ...">
                            <button type="reset"
                                onclick="window.location='{{ route('transportationRentalMember.index') }}'"
                                class="border border-gray-200 px-4 py-2 rounded-2xl">Clear</button>
                            <button type="submit"
                                class="border bg-black text-white px-4 py-2 rounded-2xl">Search</button>
                        </form>
                    </div>
                </div>
                <hr class="border-gray-400 w-full mb-4">
                @foreach ($data as $d)
                    <div class="flex gap-5">
                        @php
                            if ($d->codeTransportation === 'TP00001') {
                                $url = 'rental/car/';
                            } else {
                                $url = 'rental/motorcycle/';
                            }
                        @endphp
                        <div class="w-96">
                            <img src="{{ asset($url . $d->photo_right) }}" class="rounded-3xl">
                        </div>
                        <div class="w-full">
                            <div class="text-wrap">{{ $d->notes }}</div>
                            <div class="font-bold text-xl">{{ $d->merk->merk }} - {{ $d->model }}</div>
                            <div class="my-5 flex items-center space-x-1 text-yellow-400">
                                <!-- Bintang ke-1 -->
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.22 3.749h3.947c.969 0 1.371 1.24.588 1.81l-3.194 2.32 1.222 3.748c.3.921-.755 1.688-1.538 1.117L10 13.348l-3.196 2.323c-.782.571-1.837-.196-1.538-1.117l1.222-3.748-3.194-2.32c-.783-.57-.38-1.81.588-1.81h3.947l1.22-3.749z" />
                                </svg>
                                <!-- Ulangi 5x, lalu bisa ubah warna jika ingin bintang kosong -->
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.22 3.749h3.947c.969 0 1.371 1.24.588 1.81l-3.194 2.32 1.222 3.748c.3.921-.755 1.688-1.538 1.117L10 13.348l-3.196 2.323c-.782.571-1.837-.196-1.538-1.117l1.222-3.748-3.194-2.32c-.783-.57-.38-1.81.588-1.81h3.947l1.22-3.749z" />
                                </svg>
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.22 3.749h3.947c.969 0 1.371 1.24.588 1.81l-3.194 2.32 1.222 3.748c.3.921-.755 1.688-1.538 1.117L10 13.348l-3.196 2.323c-.782.571-1.837-.196-1.538-1.117l1.222-3.748-3.194-2.32c-.783-.57-.38-1.81.588-1.81h3.947l1.22-3.749z" />
                                </svg>
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.22 3.749h3.947c.969 0 1.371 1.24.588 1.81l-3.194 2.32 1.222 3.748c.3.921-.755 1.688-1.538 1.117L10 13.348l-3.196 2.323c-.782.571-1.837-.196-1.538-1.117l1.222-3.748-3.194-2.32c-.783-.57-.38-1.81.588-1.81h3.947l1.22-3.749z" />
                                </svg>
                                <!-- Bintang kosong -->
                                <svg class="w-6 h-6 fill-current text-gray-300" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.22 3.749h3.947c.969 0 1.371 1.24.588 1.81l-3.194 2.32 1.222 3.748c.3.921-.755 1.688-1.538 1.117L10 13.348l-3.196 2.323c-.782.571-1.837-.196-1.538-1.117l1.222-3.748-3.194-2.32c-.783-.57-.38-1.81.588-1.81h3.947l1.22-3.749z" />
                                </svg>

                                <div>
                                    <span class="font-bold">4,9</span> <span class="ml-4 text-gray-400">2578
                                        Reviews</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                @php
                                    if ($d->vehicle_statuses === 'TERSEDIA') {
                                        $bg = 'bg-emerald-100 text-emerald-700';
                                        $hide = '';
                                        $text = 'Tersedia';
                                    } elseif ($d->vehicle_statuses === 'RENTAL') {
                                        $bg = 'bg-amber-100 text-amber-700';
                                        $hide = 'hidden';
                                        $text = 'Tidak Tersedia';
                                    } else {
                                        $bg = 'bg-red-100 text-red-700';
                                        $hide = 'hidden';
                                        $text = 'Tidak Tersedia';
                                    }

                                    if ($d->codeTransportation === 'TP00001') {
                                        $btn = route('transportationsRental.show', $d->codeDetailTransportation);
                                    } else {
                                        $btn = route(
                                            'transportationsRentalMotorcycle.show',
                                            $d->codeDetailTransportation,
                                        );
                                    }
                                @endphp
                                <div class="flex gap-2">
                                    <div class="px-6 {{ $bg }} py-1 rounded-3xl">{{ $text }}</div>
                                    <a href="{{ $btn }}" class="bg-black  px-6 text-white py-1 rounded-3xl"
                                        {{ $hide }}>More
                                        ...</a>
                                </div>
                                <div class="text-xl"><span class="font-bold">Rp
                                        {{ number_format($d->rental_price, 0, ',', '.') }}
                                    </span>/ Hari</div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-gray-400 w-full mb-4 mt-4">
                @endforeach
            </div>
        </div>
    </div>
    <div id="filterModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-xl w-96">
            <h2 class="text-lg font-bold mb-4">Filter Available</h2>
            <form action="{{ route('transportationRentalMember.index') }}" method="get">
                <select class="w-full border border-gray-300 rounded-3xl px-4 py-2" id="vehicle_statuses"
                    name="vehicle_statuses" data-placeholder="Available">
                    <option value="">Pilih...</option>
                    <option value="TERSEDIA">TERSEDIA</option>
                    <option value="TIDAK TERSEDIA">TIDAK TERSEDIA</option>
                    <option value="RENTAL">RENTAL</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="mt-4 w-full bg-black text-white px-4 py-2 rounded">Submit</button>
                    <button onclick="toggleModal('filterModal')"
                        class="mt-4 bg-black w-full text-white px-4 py-2 rounded">Tutup</button>
                </div>
            </form>
        </div>
    </div>
    <div id="filterModalMerk" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-xl w-96">
            <h2 class="text-lg font-bold mb-4">Filter Merk</h2>
            <form action="{{ route('transportationRentalMember.index') }}" method="GET" class="w-full">
                <select class="w-full border border-gray-300 rounded-3xl px-4 py-2" id="codeMerk" name="codeMerk"
                    data-placeholder="Merk">
                    <option value="">Pilih...</option>
                    @foreach ($merk as $m)
                        <option value="{{ $m->codeMerk }}">{{ $m->merk }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="mt-4 w-full bg-black text-white px-4 py-2 rounded">Submit</button>
                    <button onclick="toggleModalMerk('filterModalMerk')"
                        class="mt-4 w-full bg-black text-white px-4 py-2 rounded">Tutup</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleModal(id) {
            const el = document.getElementById(id);
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                el.classList.add('flex');
            } else {
                el.classList.add('hidden');
                el.classList.remove('flex');
            }
        }
    </script>
    <script>
        function toggleModalMerk(id) {
            const modal = document.getElementById(id);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                $(document).ready(function() {
                    $('#codeMerk').select2({
                        dropdownParent: $('#filterModalMerk'),
                        width: '100%' // <== PENTING untuk full width
                    });
                });
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
    </script>
</x-app-layout>
