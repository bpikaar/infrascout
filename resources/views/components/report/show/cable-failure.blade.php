@props(['report'])

@if($report->cableFailure)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Kabelstoring') }}</h3>

        <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\CableFailure::description() }}</p>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Type storing" :p="$report->cableFailure->type_storing" />
            <x-report.show.info-item header="Locatie storing" :p="$report->cableFailure->locatie_storing" />
            <x-report.show.info-item header="Methode vaststelling" :p="$report->cableFailure->methode_vaststelling" />
            <x-report.show.info-item header="Kabel met aftakking" :p="$report->cableFailure->kabel_met_aftakking ? 'Ja' : 'Nee'" />
            <x-report.show.info-item header="Bijzonderheden" :p="$report->cableFailure->bijzonderheden" pre="true" colspan="md:col-span-2" />
            <x-report.show.info-item header="Advies" :p="$report->cableFailure->advies" pre="true" colspan="md:col-span-2" />
        </div>
    </div>
@endif
