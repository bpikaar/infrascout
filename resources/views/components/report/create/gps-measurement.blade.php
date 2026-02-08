@props(['report' => null])
<div x-show="gpsMeasurementEnabled" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">GPS-meting</h2>

    <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\GPSMeasurement::description() }}</p>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="gps_gemeten_met" value="Gemeten met" />
            <select id="gps_gemeten_met" name="gps_measurement[gemeten_met]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Veldboek 1" @selected(old('gps_measurement.gemeten_met', $report->gpsMeasurement->gemeten_met ?? '')==='Veldboek 1')>Veldboek 1</option>
                <option value="Veldboek 2" @selected(old('gps_measurement.gemeten_met', $report->gpsMeasurement->gemeten_met ?? '')==='Veldboek 2')>Veldboek 2</option>
            </select>
            <x-input-error :messages="$errors->get('gps_measurement.gemeten_met')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="gps_data_verstuurd_naar_tekenaar" value="Data verstuurd naar tekenaar" />
            <select id="gps_data_verstuurd_naar_tekenaar" name="gps_measurement[data_verstuurd_naar_tekenaar]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="0" @selected(old('gps_measurement.data_verstuurd_naar_tekenaar', (string)($report->gpsMeasurement->data_verstuurd_naar_tekenaar ?? '0'))==='0')>Nee</option>
                <option value="1" @selected(old('gps_measurement.data_verstuurd_naar_tekenaar', (string)($report->gpsMeasurement->data_verstuurd_naar_tekenaar ?? '0'))==='1')>Ja</option>
            </select>
            <x-input-error :messages="$errors->get('gps_measurement.data_verstuurd_naar_tekenaar')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="gps_signaal" value="Signaal" />
            <select id="gps_signaal" name="gps_measurement[signaal]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Slecht" @selected(old('gps_measurement.signaal', $report->gpsMeasurement->signaal ?? '')==='Slecht')>Slecht</option>
                <option value="Matig" @selected(old('gps_measurement.signaal', $report->gpsMeasurement->signaal ?? '')==='Matig')>Matig</option>
                <option value="Goed" @selected(old('gps_measurement.signaal', $report->gpsMeasurement->signaal ?? '')==='Goed')>Goed</option>
            </select>
            <x-input-error :messages="$errors->get('gps_measurement.signaal')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="gps_omgeving" value="Omgeving" />
            <select id="gps_omgeving" name="gps_measurement[omgeving]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Open veld" @selected(old('gps_measurement.omgeving', $report->gpsMeasurement->omgeving ?? '')==='Open veld')>Open veld</option>
                <option value="Tussen bebouwing" @selected(old('gps_measurement.omgeving', $report->gpsMeasurement->omgeving ?? '')==='Tussen bebouwing')>Tussen bebouwing</option>
                <option value="Bosrijk gebied" @selected(old('gps_measurement.omgeving', $report->gpsMeasurement->omgeving ?? '')==='Bosrijk gebied')>Bosrijk gebied</option>
            </select>
            <x-input-error :messages="$errors->get('gps_measurement.omgeving')" class="mt-2" />
        </div>
    </div>
</div>
