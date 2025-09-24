@props([
    'report'
])

@if($report->radioDetection)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Radiodetectie') }}</h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Signaal op kabel" :p="$report->radioDetection->signaal_op_kabel" pre="true" />
            <x-report.show.info-item header="Signaal sterkte" :p="$report->radioDetection->signaal_sterkte" />
            <x-report.show.info-item header="Frequentie" :p="$report->radioDetection->frequentie" />
            <x-report.show.info-item header="Aansluiting" :p="$report->radioDetection->aansluiting" />
            <x-report.show.info-item header="Zender type" :p="$report->radioDetection->zender_type" />

            @if($report->radioDetection->sonde_type)
                <x-report.show.info-item header="Sonde type" :p="$report->radioDetection->sonde_type" />
            @endif

            @if($report->radioDetection->geleider_frequentie)
                <x-report.show.info-item header="Geleider frequentie" :p="$report->radioDetection->geleider_frequentie" />
            @endif
        </div>
    </div>
@endif
