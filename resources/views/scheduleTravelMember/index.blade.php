<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Merk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="items-start justify-between gap-5">
                <div class="flex justify-between items-center">
                    <div class="mb-6 flex">
                        <div class="py-2 bg-black px-4 border border-black-400 text-white rounded-xl cursor-pointer"
                            onclick="toggleModal('filterModal')">Short by Date
                        </div>
                    </div>
                </div>
                <hr class="border-gray-400 w-full mb-4">
                @foreach ($data as $d)
                    <div class="flex gap-5 items-center">
                        <div class="w-44">
                            <img src="{{ asset('travel/' . $d->transportation->photo_right) }}" class="rounded-3xl">
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between">
                                <div class="uppercase font-bold text-amber-500 text-xl">
                                    {{ $d->transportation->model }}<span class="text-black">
                                        ({{ $d->hari }})</span></div>
                                <div>
                                    <div class="text-gray-500">Harga Tersedia Muali dari</div>
                                    <div><span class="font-bold text-2xl">Rp {{number_format($d->route->route_price)}}</span> <span
                                            class="text-gray-500">/seat</span></div>
                                </div>
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div class="flex gap-5 items-center">
                                        <div><i class="fi fi-ss-route" style="font-size: 30px;"></i></div>
                                        <div class="font-bold">{{ trim(Str::before($d->route->route, '-')) }}</div>
                                    </div>
                                    <div class="flex">
                                        <div class="border-2 w-1 h-12 border-black border-dashed ml-4">
                                        </div>
                                        <div></div>
                                    </div>
                                    <div class="flex gap-5 items-center">
                                        <div><i class="fi fi-ss-route" style="font-size: 30px;"></i></div>
                                        <div class="font-bold">{{ trim(Str::after($d->route->route, '-')) }}</div>
                                    </div>
                                </div>
                                <div class="flex gap-2 mb-[10px]">
                                    <div class="px-6 py-1 rounded-3xl"></div>
                                    <a href="{{route('transportationTravelMember.show', $d->id)}}" class="bg-black  px-6 text-white py-1 rounded-3xl">More
                                        ...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-gray-400 w-full mb-4 mt-4">
                @endforeach
            </div>
        </div>
    </div>
    {{-- <div id="filterModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-xl w-96">
            <h2 class="text-lg font-bold mb-4">Filter Available</h2>
            <form action="{{ route('transportationTravelMember.index') }}" method="get">
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
            <form action="{{ route('transportationTravelMember.index') }}" method="GET" class="w-full">
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
    </div> --}}
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
