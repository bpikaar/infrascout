@props([
    'report'
])

@if($report->groundRadar)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">Grondradar</h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Onderzoeksgebied" :p="$report->groundRadar->onderzoeksgebied" />
            <x-report.show.info-item header="Scanrichting" :p="$report->groundRadar->scanrichting" />
            <x-report.show.info-item header="Ingestelde detectiediepte (m)" :p="$report->groundRadar->ingestelde_detectiediepte" />
            <x-report.show.info-item header="Reflecties / objecten" :p="$report->groundRadar->reflecties" pre="true" colspan="md:col-span-2" />
            <x-report.show.info-item header="Interpretatie" :p="$report->groundRadar->interpretatie" />
        </div>
    </div>
@endif
