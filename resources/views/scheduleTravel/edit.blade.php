<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Schedule Travel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-start justify-between gap-5">
                <div class="bg-white px-12 pt-5 pb-6 rounded-3xl border shadow-xl w-full">
                    <div class="flex items-center gap-3">
                        <div class="w-12"><img src="{{ url('/assets/img/form.png') }}" alt="" srcset="">
                        </div>
                        <div class="font-bold text-xl">Form Edit Schedule Travel</div>
                    </div>
                    <hr class="mb-4 mt-3 border-2 rounded-xl">
                    <div>
                        <form action="{{ route('schedule.update', $scheduleRoute->id) }}" method="post"
                            id="transportationsRentalForm" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="border border-gray-100 px-6 pt-4 rounded-3xl mb-4">
                                <div class="grid grid-cols-3 gap-5">
                                    <div class="mb-5 hidden">
                                        <div
                                            class="mb-2 text-md font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                            <i class="fi fi-rr-input-numeric flex"></i> <span>Kode Detail Transportasi
                                                <span class="text-red-500">*</span></span>
                                        </div>
                                        <input type="text" name="codeSchedule" id="codeSchedule"
                                            class="w-full border border-gray-300 rounded-3xl px-4 bg-gray-100"
                                            placeholder="Kode Detail Transportasi ....."
                                            oninput="this.value = this.value.toUpperCase();" value="{{ $codeSchedule }}"
                                            readonly>
                                        <p id="error-codeSchedule" class="mt-2 text-sm text-red-500 hidden">
                                            Kode Detail Transportasi wajib
                                            diisi.</p>
                                    </div>
                                    <div class="mb-5">
                                        <div
                                            class="mb-2 text-md font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                            <i class="fi fi-rr-id-card-clip-alt flex"></i> <span>Hari <span
                                                    class="text-red-500">*</span></span>
                                        </div>
                                        <select
                                            class="js-example-placeholder-single js-states form-control w-full m-6 border border-gray-300 rounded-3xl px-4"
                                            id="hari" name="hari" data-placeholder="Hari">
                                            <option value="">Pilih...</option>
                                            <option value="SENIN"
                                                {{ $scheduleRoute->hari == 'SENIN' ? 'selected' : '' }}>SENIN</option>
                                            <option value="SELASA"
                                                {{ $scheduleRoute->hari == 'SELASA' ? 'selected' : '' }}>SELASA</option>
                                            <option value="RABU"
                                                {{ $scheduleRoute->hari == 'RABU' ? 'selected' : '' }}>RABU</option>
                                            <option value="KAMIS"
                                                {{ $scheduleRoute->hari == 'KAMIS' ? 'selected' : '' }}>KAMIS</option>
                                            <option value="JUMAT"
                                                {{ $scheduleRoute->hari == 'JUMAT' ? 'selected' : '' }}>JUMAT</option>
                                            <option value="SABTU"
                                                {{ $scheduleRoute->hari == 'SABTU' ? 'selected' : '' }}>SABTU</option>
                                            <option value="MINGGU"
                                                {{ $scheduleRoute->hari == 'MINGGU' ? 'selected' : '' }}>MINGGU
                                            </option>
                                        </select>
                                        <p id="error-hari" class="mt-2 text-sm text-red-500 hidden">Hari wajib
                                            diisi.</p>
                                    </div>
                                    <div class="mb-5">
                                        <div
                                            class="mb-2 text-md font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                            <i class="fi fi-rr-id-card-clip-alt flex"></i> <span>Rute <span
                                                    class="text-red-500">*</span></span>
                                        </div>
                                        <select
                                            class="js-example-placeholder-single js-states form-control w-full m-6 border border-gray-300 rounded-3xl px-4"
                                            id="codeRoute" name="codeRoute" data-placeholder="Rute">
                                            <option value="">Pilih...</option>
                                            @foreach ($route as $m)
                                                <option value="{{ $m->codeRoute }}"
                                                    {{ $scheduleRoute->codeRoute == $m->codeRoute ? 'selected' : '' }}>
                                                    {{ $m->route }}</option>
                                            @endforeach
                                        </select>
                                        <p id="error-codeRoute" class="mt-2 text-sm text-red-500 hidden">Rute wajib
                                            diisi.</p>
                                    </div>
                                    <div class="mb-5">
                                        <div
                                            class="mb-2 text-md font-medium text-gray-900 dark:text-white flex items-center gap-3">
                                            <i class="fi fi-rr-id-card-clip-alt flex"></i> <span>Transportasi <span
                                                    class="text-red-500">*</span></span>
                                        </div>
                                        <select
                                            class="js-example-placeholder-single js-states form-control w-full m-6 border border-gray-300 rounded-3xl px-4"
                                            id="codeDetailTransportation" name="codeDetailTransportation"
                                            data-placeholder="Transportasi">
                                            <option value="">Pilih...</option>
                                            @foreach ($transportation as $d)
                                                <option value="{{ $d->codeDetailTransportation }}"
                                                    {{ $scheduleRoute->codeDetailTransportation == $d->codeDetailTransportation ? 'selected' : '' }}>
                                                    {{ $d->model }}</option>
                                            @endforeach
                                        </select>
                                        <p id="error-codeDetailTransportation" class="mt-2 text-sm text-red-500 hidden">
                                            Transportasi wajib
                                            diisi.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex">
                                <button
                                    class="flex border border-sky-500 px-4 pt-2 pb-2 rounded-full text-sky-500 hover:bg-sky-100"
                                    type="submit"><i class="fi fi-rr-disk flex mr-2 mt-1"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        flatpickr("#production_year", {
            dateFormat: "Y",
            defaultDate: new Date(),
            onReady: function(selectedDates, dateStr, instance) {
                instance.currentYearElement.focus();
            }
        });
    </script>

    <script>
        function formatRupiah(el) {
            let value = el.value.replace(/\D/g, "");
            el.value = new Intl.NumberFormat("id-ID").format(value);
            document.getElementById('rental_price').value = value;
        }
    </script>

    <script>
        const form = document.getElementById('transportationsRentalForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let isValid = true;

            const inputs = this.querySelectorAll('input');

            inputs.forEach((input) => {
                const errorElement = document.getElementById(`error-${input.name}`);

                if (input.value.trim() === '') {
                    errorElement?.classList.remove('hidden');
                    isValid = false;
                } else {
                    errorElement?.classList.add('hidden');
                }
            });

            if (isValid) {
                form.submit();
            }
        });
    </script>

</x-app-layout>
