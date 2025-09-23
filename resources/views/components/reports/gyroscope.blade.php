<div x-show="enabledGyroscope" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Gyroscoop</h2>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="gyro_type_boring" value="Type boring" />
            <select id="gyro_type_boring" name="gyroscope[type_boring]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="HDD" @selected(old('gyroscope.type_boring')==='HDD')>HDD</option>
                <option value="Persing" @selected(old('gyroscope.type_boring')==='Persing')>Persing</option>
                <option value="Overig" @selected(old('gyroscope.type_boring')==='Overig')>Overig</option>
            </select>
            <x-input-error :messages="$errors->get('gyroscope.type_boring')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_intredepunt" value="Intredepunt" />
            <x-text-input id="gyro_intredepunt" name="gyroscope[intredepunt]" type="text" class="block mt-1 w-full" :value="old('gyroscope.intredepunt')" />
            <x-input-error :messages="$errors->get('gyroscope.intredepunt')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_uittredepunt" value="Uittredepunt" />
            <x-text-input id="gyro_uittredepunt" name="gyroscope[uittredepunt]" type="text" class="block mt-1 w-full" :value="old('gyroscope.uittredepunt')" />
            <x-input-error :messages="$errors->get('gyroscope.uittredepunt')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_lengte_trace" value="Lengte tracé (m)" />
            <x-text-input id="gyro_lengte_trace" name="gyroscope[lengte_trace]" type="number" step="0.01" class="block mt-1 w-full" :value="old('gyroscope.lengte_trace')" />
            <x-input-error :messages="$errors->get('gyroscope.lengte_trace')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_bodemprofiel" value="Bodemprofiel ingemeten met GPS" />
            <select id="gyro_bodemprofiel" name="gyroscope[bodemprofiel_ingemeten_met_gps]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="0" @selected(old('gyroscope.bodemprofiel_ingemeten_met_gps')==='0')>Nee</option>
                <option value="1" @selected(old('gyroscope.bodemprofiel_ingemeten_met_gps')==='1')>Ja</option>
            </select>
            <x-input-error :messages="$errors->get('gyroscope.bodemprofiel_ingemeten_met_gps')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_diameter_buis" value="Diameter buis (mm)" />
            <x-text-input id="gyro_diameter_buis" name="gyroscope[diameter_buis]" type="number" step="0.01" class="block mt-1 w-full" :value="old('gyroscope.diameter_buis')" />
            <x-input-error :messages="$errors->get('gyroscope.diameter_buis')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_materiaal" value="Materiaal" />
            <select id="gyro_materiaal" name="gyroscope[materiaal]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="PVC" @selected(old('gyroscope.materiaal')==='PVC')>PVC</option>
                <option value="PE" @selected(old('gyroscope.materiaal')==='PE')>PE</option>
                <option value="HDPE" @selected(old('gyroscope.materiaal')==='HDPE')>HDPE</option>
                <option value="Gietijzer" @selected(old('gyroscope.materiaal')==='Gietijzer')>Gietijzer</option>
                <option value="Staal" @selected(old('gyroscope.materiaal')==='Staal')>Staal</option>
                <option value="RVS" @selected(old('gyroscope.materiaal')==='RVS')>RVS</option>
                <option value="Overig" @selected(old('gyroscope.materiaal')==='Overig')>Overig</option>
            </select>
            <x-input-error :messages="$errors->get('gyroscope.materiaal')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gyro_ingemeten_met" value="Ingemeten met" />
            <select id="gyro_ingemeten_met" name="gyroscope[ingemeten_met]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Trektouw" @selected(old('gyroscope.ingemeten_met')==='Trektouw')>Trektouw</option>
                <option value="Cable-pusher (glasfiber pees)" @selected(old('gyroscope.ingemeten_met')==='Cable-pusher (glasfiber pees)')>Cable-pusher (glasfiber pees)</option>
            </select>
            <x-input-error :messages="$errors->get('gyroscope.ingemeten_met')" class="mt-2" />
        </div>

        <div class="md:col-span-2">
            <x-input-label for="gyro_bijzonderheden" value="Bijzonderheden" />
            <textarea id="gyro_bijzonderheden" name="gyroscope[bijzonderheden]" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('gyroscope.bijzonderheden') }}</textarea>
            <x-input-error :messages="$errors->get('gyroscope.bijzonderheden')" class="mt-2" />
        </div>
    </div>
</div>
