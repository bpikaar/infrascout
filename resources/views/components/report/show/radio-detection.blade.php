@props([
    'report'
])

@if($report->radioDetection)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Radiodetectie') }}</h3>

        <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\RadioDetection::description() }}</p>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Signaal op kabel" :p="$report->radioDetection->signaal_op_kabel" pre="true" />
            <x-report.show.info-item header="Signaal sterkte" :p="$report->radioDetection->signaal_sterkte" />
            <x-report.show.info-item header="Frequentie" :p="$report->radioDetection->frequentie" />
            <x-report.show.info-item header="Aansluiting" :p="$report->radioDetection->aansluiting" />
            <x-report.show.info-item header="Zender type" :p="$report->radioDetection->zender_type" />

            <div></div>

            @if($report->radioDetection->sonde_type)

                <div class="flex flex-col">
                    <label class="flex items-start space-x-2">
                        <input type="checkbox" disabled checked class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        <span class="text-gray-800 dark:text-gray-200 font-semibold">Signaal met sonde</span>
                    </label>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ __('report.description.signaal_met_sonde') }}</p>
                </div>

                <x-report.show.info-item header="Sonde type" :p="$report->radioDetection->sonde_type" />
            @endif

            @if($report->radioDetection->geleider_frequentie)
                <div class="flex flex-col">
                    <label class="flex items-start space-x-2">
                        <input type="checkbox" disabled checked class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        <span class="text-gray-800 dark:text-gray-200 font-semibold">Signaal met geleider</span>
                    </label>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ __('report.description.signaal_met_geleider') }}</p>
                </div>
                <x-report.show.info-item header="Geleider frequentie" :p="$report->radioDetection->geleider_frequentie" />
            @endif
        </div>
    </div>
@endif
