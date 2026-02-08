@props(['report' => null])
<div x-show="enabledGyroscope" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Gyroscoop</h2>

    @php($gyro = $report?->gyroscope)
    <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\Gyroscope::description() }}</p>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="gyro_type_boring" value="Type boring" />
            <select id="gyro_type_boring" name="gyroscope[type_boring]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="HDD" @selected(old('gyroscope.type_boring', $gyro->type_boring ?? '')==='HDD')>HDD</option>
                <option value="Persing" @selected(old('gyroscope.type_boring', $gyro->type_boring ?? '')==='Persing')>Persing</option>
                <option value="Overig" @selected(old('gyroscope.type_boring', $gyro->type_boring ?? '')==='Overig')>Overig</option>
            </select>
            <x-input-error :messages="$errors->get('gyroscope.type_boring')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_intredepunt" value="Intredepunt" />
            <x-text-input id="gyro_intredepunt" name="gyroscope[intredepunt]" type="text" class="block mt-1 w-full" :value="old('gyroscope.intredepunt', $gyro->intredepunt ?? '')" />
            <x-input-error :messages="$errors->get('gyroscope.intredepunt')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_uittredepunt" value="Uittredepunt" />
            <x-text-input id="gyro_uittredepunt" name="gyroscope[uittredepunt]" type="text" class="block mt-1 w-full" :value="old('gyroscope.uittredepunt', $gyro->uittredepunt ?? '')" />
            <x-input-error :messages="$errors->get('gyroscope.uittredepunt')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_lengte_trace" value="Lengte tracé (m)" />
            <x-text-input id="gyro_lengte_trace" name="gyroscope[lengte_trace]" type="number" step="0.01" class="block mt-1 w-full" :value="old('gyroscope.lengte_trace', $gyro->lengte_trace ?? '')" />
            <x-input-error :messages="$errors->get('gyroscope.lengte_trace')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_bodemprofiel" value="Bodemprofiel ingemeten met GPS" />
            <select id="gyro_bodemprofiel" name="gyroscope[bodemprofiel_ingemeten_met_gps]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="0" @selected(old('gyroscope.bodemprofiel_ingemeten_met_gps', (string)($gyro->bodemprofiel_ingemeten_met_gps ?? '0'))==='0')>Nee</option>
                <option value="1" @selected(old('gyroscope.bodemprofiel_ingemeten_met_gps', (string)($gyro->bodemprofiel_ingemeten_met_gps ?? '0'))==='1')>Ja</option>
            </select>
            <x-input-error :messages="$errors->get('gyroscope.bodemprofiel_ingemeten_met_gps')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_diameter_buis" value="Diameter buis (mm)" />
            <x-text-input id="gyro_diameter_buis" name="gyroscope[diameter_buis]" type="number" step="0.01" class="block mt-1 w-full" :value="old('gyroscope.diameter_buis', $gyro->diameter_buis ?? '')" />
            <x-input-error :messages="$errors->get('gyroscope.diameter_buis')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_materiaal" value="Materiaal" />
            <select id="gyro_materiaal" name="gyroscope[materiaal]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="PVC" @selected(old('gyroscope.materiaal', $gyro->materiaal ?? '')==='PVC')>PVC</option>
                <option value="PE" @selected(old('gyroscope.materiaal', $gyro->materiaal ?? '')==='PE')>PE</option>
                <option value="HDPE" @selected(old('gyroscope.materiaal', $gyro->materiaal ?? '')==='HDPE')>HDPE</option>
                <option value="Gietijzer" @selected(old('gyroscope.materiaal', $gyro->materiaal ?? '')==='Gietijzer')>Gietijzer</option>
                <option value="Staal" @selected(old('gyroscope.materiaal', $gyro->materiaal ?? '')==='Staal')>Staal</option>
                <option value="RVS" @selected(old('gyroscope.materiaal', $gyro->materiaal ?? '')==='RVS')>RVS</option>
                <option value="Overig" @selected(old('gyroscope.materiaal', $gyro->materiaal ?? '')==='Overig')>Overig</option>
            </select>
            <x-input-error :messages="$errors->get('gyroscope.materiaal')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_ingemeten_met" value="Ingemeten met" />
            <select id="gyro_ingemeten_met" name="gyroscope[ingemeten_met]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Trektouw" @selected(old('gyroscope.ingemeten_met', $gyro->ingemeten_met ?? '')==='Trektouw')>Trektouw</option>
                <option value="Cable-pusher (glasfiber pees)" @selected(old('gyroscope.ingemeten_met', $gyro->ingemeten_met ?? '')==='Cable-pusher (glasfiber pees)')>Cable-pusher (glasfiber pees)</option>
            </select>
            <x-input-error :messages="$errors->get('gyroscope.ingemeten_met')" class="mt-2" />
        </div>

        <div class="md:col-span-2">
            <x-input-label for="gyro_bijzonderheden" value="Bijzonderheden" />
            <textarea id="gyro_bijzonderheden" name="gyroscope[bijzonderheden]" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('gyroscope.bijzonderheden', $gyro->bijzonderheden ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('gyroscope.bijzonderheden')" class="mt-2" />
        </div>
    </div>
</div>
