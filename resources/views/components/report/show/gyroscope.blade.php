@props([
    'report'
])

@if($report->gyroscope)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">Gyroscoop</h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Type boring" :p="$report->gyroscope->type_boring" />
            <x-report.show.info-item header="Intredepunt" :p="$report->gyroscope->intredepunt" />
            <x-report.show.info-item header="Uittredepunt" :p="$report->gyroscope->uittredepunt" />
            <x-report.show.info-item header="Lengte tracé (m)" :p="$report->gyroscope->lengte_trace" />
            <x-report.show.info-item header="Bodemprofiel ingemeten met GPS" :p="$report->gyroscope->bodemprofiel_ingemeten_met_gps ? 'Ja' : 'Nee'" />
            <x-report.show.info-item header="Diameter buis (mm)" :p="$report->gyroscope->diameter_buis" />
            <x-report.show.info-item header="Materiaal" :p="$report->gyroscope->materiaal" />
            <x-report.show.info-item header="Ingemeten met" :p="$report->gyroscope->ingemeten_met" />
        </div>

        @if($report->gyroscope->bijzonderheden)
            <x-report.show.info-item class="mt-4" header="Bijzonderheden" :p="$report->gyroscope->bijzonderheden" pre="true" colspan="md:col-span-2" />
        @endif
    </div>
@endif
