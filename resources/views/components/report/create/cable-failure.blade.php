@props(['report' => null])
<div x-show="cableFailureEnabled" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Kabelstoring</h2>

    <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\CableFailure::description() }}</p>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="cf_type_storing" value="Type storing" />
            <select id="cf_type_storing" name="cable_failure[type_storing]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Kabelbreuk" @selected(old('cable_failure.type_storing', $report->cableFailure->type_storing ?? '') === 'Kabelbreuk')>Kabelbreuk</option>
                <option value="Slechte verbinding" @selected(old('cable_failure.type_storing', $report->cableFailure->type_storing ?? '') === 'Slechte verbinding')>Slechte verbinding</option>
                <option value="Kortsluiting" @selected(old('cable_failure.type_storing', $report->cableFailure->type_storing ?? '') === 'Kortsluiting')>Kortsluiting</option>
                <option value="Overig" @selected(old('cable_failure.type_storing', $report->cableFailure->type_storing ?? '') === 'Overig')>Overig</option>
            </select>
            <x-input-error :messages="$errors->get('cable_failure.type_storing')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="cf_locatie_storing" value="Locatie storing" />
            <x-text-input id="cf_locatie_storing" name="cable_failure[locatie_storing]" type="text" class="block mt-1 w-full" :value="old('cable_failure.locatie_storing', $report->cableFailure->locatie_storing ?? '')" />
            <x-input-error :messages="$errors->get('cable_failure.locatie_storing')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="cf_kabel_met_aftakking" value="Kabel met aftakking" />
            <select id="cf_kabel_met_aftakking" name="cable_failure[kabel_met_aftakking]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="0" @selected(old('cable_failure.kabel_met_aftakking', (string) ($report->cableFailure->kabel_met_aftakking ?? '0')) === '0')>Nee</option>
                <option value="1" @selected(old('cable_failure.kabel_met_aftakking', (string) ($report->cableFailure->kabel_met_aftakking ?? '0')) === '1')>Ja</option>
            </select>
            <x-input-error :messages="$errors->get('cable_failure.kabel_met_aftakking')" class="mt-2" />
        </div>
        <div class="hidden md:block"></div>
        <div class="md:col-span-2 mt-4">
            <h3 class="font-medium text-gray-900 dark:text-gray-100 mb-2">Methode vaststelling</h3>
            <div class="space-y-4">
                <!-- A-frame -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="cf_a_frame" name="cable_failure[a_frame]" type="checkbox" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" @checked(old('cable_failure.a_frame', $report->cableFailure->a_frame ?? false))>
                    </div>
                    <div class="ms-2 text-sm">
                        <label for="cf_a_frame" class="font-medium text-gray-900 dark:text-gray-300">A-frame</label>
                        <p class="text-xs font-normal text-gray-500 dark:text-gray-400 whitespace-pre-line mt-1">{{ \App\Models\MethodDescription::where('method_type', \App\Enums\MethodType::AFrame->value)->value('description') }}</p>
                    </div>
                </div>

                <!-- TDR -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="cf_tdr" name="cable_failure[tdr]" type="checkbox" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" @checked(old('cable_failure.tdr', $report->cableFailure->tdr ?? false))>
                    </div>
                    <div class="ms-2 text-sm">
                        <label for="cf_tdr" class="font-medium text-gray-900 dark:text-gray-300">TDR</label>
                        <p class="text-xs font-normal text-gray-500 dark:text-gray-400 whitespace-pre-line mt-1">{{ \App\Models\MethodDescription::where('method_type', \App\Enums\MethodType::TDR->value)->value('description') }}</p>
                    </div>
                </div>

                <!-- Isolatieweerstandmeting -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="cf_isolatieweerstandmeting" name="cable_failure[isolatieweerstandmeting]" type="checkbox" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" @checked(old('cable_failure.isolatieweerstandmeting', $report->cableFailure->isolatieweerstandmeting ?? false))>
                    </div>
                    <div class="ms-2 text-sm">
                        <label for="cf_isolatieweerstandmeting" class="font-medium text-gray-900 dark:text-gray-300">Isolatieweerstandmeting (Meggeren)</label>
                        <p class="text-xs font-normal text-gray-500 dark:text-gray-400 whitespace-pre-line mt-1">{{ \App\Models\MethodDescription::where('method_type', \App\Enums\MethodType::Meggeren->value)->value('description') }}</p>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('cable_failure.a_frame')" class="mt-2" />
            <x-input-error :messages="$errors->get('cable_failure.tdr')" class="mt-2" />
            <x-input-error :messages="$errors->get('cable_failure.isolatieweerstandmeting')" class="mt-2" />
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

        <x-report.create.method-image-upload id="cf_images" name="method_images[{{ \App\Enums\MethodType::CableFailure->value }}][]" label="Afbeeldingen Kabelstoring" />
    </div>
</div>