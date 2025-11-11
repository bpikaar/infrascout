@props(['report' => null])
<div x-show="groundRadarEnabled" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Grondradar</h2>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="gr_radarbeeld" value="Radarbeeld" />
            <select id="gr_radarbeeld" name="ground_radar[radarbeeld]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Slecht" @selected(old('ground_radar.radarbeeld', $report->groundRadar->radarbeeld ?? '')==='Slecht')>Slecht</option>
                <option value="Matig" @selected(old('ground_radar.radarbeeld', $report->groundRadar->radarbeeld ?? '')==='Matig')>Matig</option>
                <option value="Goed" @selected(old('ground_radar.radarbeeld', $report->groundRadar->radarbeeld ?? '')==='Goed')>Goed</option>
                <option value="Zeer Goed" @selected(old('ground_radar.radarbeeld', $report->groundRadar->radarbeeld ?? '')==='Zeer Goed')>Zeer Goed</option>
            </select>
            <x-input-error :messages="$errors->get('ground_radar.radarbeeld')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gr_ingestelde_detectiediepte" value="Ingestelde detectiediepte" />
            <x-text-input id="gr_ingestelde_detectiediepte" name="ground_radar[ingestelde_detectiediepte]" type="text" class="block mt-1 w-full" :value="old('ground_radar.ingestelde_detectiediepte', $report->groundRadar->ingestelde_detectiediepte ?? '')" />
            <x-input-error :messages="$errors->get('ground_radar.ingestelde_detectiediepte')" class="mt-2" />
        </div>
    </div>
</div>
