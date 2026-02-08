@props(['report'])

@if($report->gpsMeasurement)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('GPS-meting') }}</h3>

        <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\GPSMeasurement::description() }}</p>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Gemeten met" :p="$report->gpsMeasurement->gemeten_met" />
            <x-report.show.info-item header="Data verstuurd naar tekenaar" :p="$report->gpsMeasurement->data_verstuurd_naar_tekenaar ? 'Ja' : 'Nee'" />
            <x-report.show.info-item header="Signaal" :p="$report->gpsMeasurement->signaal" />
            <x-report.show.info-item header="Omgeving" :p="$report->gpsMeasurement->omgeving" />
        </div>
    </div>
@endif
