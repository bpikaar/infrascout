@props(['report'])

@if($report->lance)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">Aanlansen / aanprikken</h3>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
                $depth = $report->lance->aanprikdiepte !== null ? number_format($report->lance->aanprikdiepte, 2) : '-';
            @endphp
            <x-report.show.info-item header="aanprikdiepte (m)" :p="$depth" />
        </div>
    </div>
@endif
