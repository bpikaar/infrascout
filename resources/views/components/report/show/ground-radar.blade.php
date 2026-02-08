@props([
    'report'
])

@if($report->groundRadar)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">Grondradar</h3>

        <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\GroundRadar::description() }}</p>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Radarbeeld" :p="$report->groundRadar->radarbeeld" />
            <x-report.show.info-item header="Ingestelde detectiediepte (m)" :p="$report->groundRadar->ingestelde_detectiediepte" />
        </div>
    </div>
@endif
