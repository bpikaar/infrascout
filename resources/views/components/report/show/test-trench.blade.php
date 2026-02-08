@props([
    'report'
])

@if($report->testTrench)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Proefsleuf') }}</h3>

        <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\TestTrench::description() }}</p>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Proefsleuf gemaakt" :p="$report->testTrench->proefsleuf_gemaakt ? 'Ja' : 'Nee'" />

            <x-report.show.info-item header="Manier van graven" :p="$report->testTrench->manier_van_graven" />
            <x-report.show.info-item header="Type grondslag" :p="$report->testTrench->type_grondslag" />
            <x-report.show.info-item header="KLIC-melding gedaan" :p="$report->testTrench->klic_melding_gedaan ? 'Ja' : 'Nee'" />
            <x-report.show.info-item header="KLIC-nummer" :p="$report->testTrench->klic_nummer" />
            <x-report.show.info-item header="Locatie" :p="$report->testTrench->locatie" pre="true" colspan="md:col-span-2" />
            <x-report.show.info-item header="Doel" :p="$report->testTrench->doel" />
            <x-report.show.info-item header="Bevindingen" :p="$report->testTrench->bevindingen" pre="true" colspan="md:col-span-2" />
        </div>
    </div>
@endif
