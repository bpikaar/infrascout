@props(['report' => null])
<div x-show="cableFailureEnabled" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Kabelstoring</h2>

    <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\CableFailure::description() }}</p>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="cf_type_storing" value="Type storing" />
            <select id="cf_type_storing" name="cable_failure[type_storing]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Kabelbreuk" @selected(old('cable_failure.type_storing', $report->cableFailure->type_storing ?? '')==='Kabelbreuk')>Kabelbreuk</option>
                <option value="Slechte verbinding" @selected(old('cable_failure.type_storing', $report->cableFailure->type_storing ?? '')==='Slechte verbinding')>Slechte verbinding</option>
                <option value="Kortsluiting" @selected(old('cable_failure.type_storing', $report->cableFailure->type_storing ?? '')==='Kortsluiting')>Kortsluiting</option>
                <option value="Overig" @selected(old('cable_failure.type_storing', $report->cableFailure->type_storing ?? '')==='Overig')>Overig</option>
            </select>
            <x-input-error :messages="$errors->get('cable_failure.type_storing')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="cf_locatie_storing" value="Locatie storing" />
            <x-text-input id="cf_locatie_storing" name="cable_failure[locatie_storing]" type="text" class="block mt-1 w-full" :value="old('cable_failure.locatie_storing', $report->cableFailure->locatie_storing ?? '')" />
            <x-input-error :messages="$errors->get('cable_failure.locatie_storing')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="cf_methode_vaststelling" value="Methode vaststelling" />
            <select id="cf_methode_vaststelling" name="cable_failure[methode_vaststelling]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="A-frame" @selected(old('cable_failure.methode_vaststelling', $report->cableFailure->methode_vaststelling ?? '')==='A-frame')>A-frame</option>
                <option value="TDR" @selected(old('cable_failure.methode_vaststelling', $report->cableFailure->methode_vaststelling ?? '')==='TDR')>TDR</option>
                <option value="Meggeren" @selected(old('cable_failure.methode_vaststelling', $report->cableFailure->methode_vaststelling ?? '')==='Meggeren')>Meggeren</option>
            </select>
            <x-input-error :messages="$errors->get('cable_failure.methode_vaststelling')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="cf_kabel_met_aftakking" value="Kabel met aftakking" />
            <select id="cf_kabel_met_aftakking" name="cable_failure[kabel_met_aftakking]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="0" @selected(old('cable_failure.kabel_met_aftakking', (string)($report->cableFailure->kabel_met_aftakking ?? '0'))==='0')>Nee</option>
                <option value="1" @selected(old('cable_failure.kabel_met_aftakking', (string)($report->cableFailure->kabel_met_aftakking ?? '0'))==='1')>Ja</option>
            </select>
            <x-input-error :messages="$errors->get('cable_failure.kabel_met_aftakking')" class="mt-2" />
        </div>
        <div class="md:col-span-2">
            <x-input-label for="cf_bijzonderheden" value="Bijzonderheden" />
            <textarea id="cf_bijzonderheden" name="cable_failure[bijzonderheden]" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('cable_failure.bijzonderheden', $report->cableFailure->bijzonderheden ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('cable_failure.bijzonderheden')" class="mt-2" />
        </div>
        <div class="md:col-span-2">
            <x-input-label for="cf_advies" value="Advies" />
            <textarea id="cf_advies" name="cable_failure[advies]" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('cable_failure.advies', $report->cableFailure->advies ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('cable_failure.advies')" class="mt-2" />
        </div>
    </div>
</div>
