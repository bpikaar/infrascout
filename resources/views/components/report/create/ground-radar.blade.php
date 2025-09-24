<div x-show="groundRadarEnabled" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Grondradar</h2>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="gr_onderzoeksgebied" value="Onderzoeksgebied" />
            <select id="gr_onderzoeksgebied" name="ground_radar[onderzoeksgebied]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Oppervlak" @selected(old('ground_radar.onderzoeksgebied')==='Oppervlak')>Oppervlak</option>
                <option value="Grid" @selected(old('ground_radar.onderzoeksgebied')==='Grid')>Grid</option>
            </select>
            <x-input-error :messages="$errors->get('ground_radar.onderzoeksgebied')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gr_scanrichting" value="Scanrichting" />
            <select id="gr_scanrichting" name="ground_radar[scanrichting]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="X" @selected(old('ground_radar.scanrichting')==='X')>X</option>
                <option value="Y" @selected(old('ground_radar.scanrichting')==='Y')>Y</option>
                <option value="Beide" @selected(old('ground_radar.scanrichting')==='Beide')>Beide</option>
            </select>
            <x-input-error :messages="$errors->get('ground_radar.scanrichting')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gr_ingestelde_detectiediepte" value="ingestelde detectiediepte (m)" />
            <x-text-input id="gr_ingestelde_detectiediepte" name="ground_radar[ingestelde_detectiediepte]" type="number" step="0.01" class="block mt-1 w-full" :value="old('ground_radar.ingestelde_detectiediepte')" />
            <x-input-error :messages="$errors->get('ground_radar.ingestelde_detectiediepte')" class="mt-2" />
        </div>

        <div class="md:col-span-2">
            <x-input-label for="gr_reflecties" value="Reflecties / objecten" />
            <textarea id="gr_reflecties" name="ground_radar[reflecties]" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('ground_radar.reflecties') }}</textarea>
            <x-input-error :messages="$errors->get('ground_radar.reflecties')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="gr_interpretatie" value="Interpretatie" />
            <select id="gr_interpretatie" name="ground_radar[interpretatie]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Leidingen" @selected(old('ground_radar.interpretatie')==='Leidingen/kabels')>Leidingen</option>
                <option value="Kabels" @selected(old('ground_radar.interpretatie')==='Leidingen/kabels')>Kabels</option>
                <option value="Holtes" @selected(old('ground_radar.interpretatie')==='Holtes')>Holtes</option>
                <option value="Obstakels" @selected(old('ground_radar.interpretatie')==='Obstakels')>Obstakels</option>
                <option value="Onbekend signaal" @selected(old('ground_radar.interpretatie')==='Onbekend signaal')>Onbekend signaal</option>
            </select>
            <x-input-error :messages="$errors->get('ground_radar.interpretatie')" class="mt-2" />
        </div>
    </div>
</div>
