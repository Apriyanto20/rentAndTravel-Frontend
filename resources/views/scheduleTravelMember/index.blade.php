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
                        <form action="{{ route('transportationTravelMember.index') }}" method="GET"
                            class="flex items-center gap-2">
                            <input type="date" name="tgl_berangkat"
                                value="{{ request('tgl_berangkat') ?? date('Y-m-d') }}" onchange="this.form.submit()"
                                class="bg-gray-200 border border-gray-200 rounded-2xl w-96 px-4 py-2"
                                placeholder="Search ...">
                        </form>
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
                                        ({{ $d->hari }})
                                    </span></div>
                                <div>
                                    <div class="text-gray-500">Harga Tersedia Muali dari</div>
                                    <div><span class="font-bold text-2xl">Rp
                                            {{ number_format($d->route->route_price) }}</span> <span
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
                                    @php
                                        $tgl = request('tgl_berangkat') ?? date('Y-m-d');
                                    @endphp

                                    <a href="{{ route('transportationTravelMember.show', ['transportationTravelMember' => $d->id]) }}?tgl_berangkat={{ $tgl }}"
                                        class="bg-black px-6 text-white py-1 rounded-3xl">More ...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-gray-400 w-full mb-4 mt-4">
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
