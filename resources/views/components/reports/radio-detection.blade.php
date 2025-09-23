<div x-data="{ enabled: @js(old('radio_detection_enabled', false)), type: @js(old('radio_detection.aansluiting','Passief')) }" class="space-y-6">
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.work_performed') }}</h2>
        <label class="inline-flex items-center space-x-2">
            <input type="checkbox" name="radio_detection_enabled" x-model="enabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
            <span class="text-gray-700 dark:text-gray-300">{{ __('Radiodetectie') }}</span>
        </label>
    </div>

    <div x-show="enabled" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('Radiodetectie') }}</h2>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <x-input-label for="rd_signaal_op_kabel" value="Signaal op kabel" />
                <textarea id="rd_signaal_op_kabel" name="radio_detection[signaal_op_kabel]" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('radio_detection.signaal_op_kabel') }}</textarea>
                <x-input-error :messages="$errors->get('radio_detection.signaal_op_kabel')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="rd_signaal_sterkte" value="Signaal sterkte" />
                <x-text-input id="rd_signaal_sterkte" name="radio_detection[signaal_sterkte]" type="text" class="block mt-1 w-full" :value="old('radio_detection.signaal_sterkte')" />
                <x-input-error :messages="$errors->get('radio_detection.signaal_sterkte')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="rd_frequentie" value="Frequentie" />
                <x-text-input id="rd_frequentie" name="radio_detection[frequentie]" type="text" class="block mt-1 w-full" :value="old('radio_detection.frequentie')" />
                <x-input-error :messages="$errors->get('radio_detection.frequentie')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="rd_aansluiting" value="Aansluiting" />
                <select id="rd_aansluiting" name="radio_detection[aansluiting]" x-model="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                    <option value="Passief">Passief</option>
                    <option value="Actief">Actief</option>
                </select>
                <x-input-error :messages="$errors->get('radio_detection.aansluiting')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="rd_zender_type" value="Zender type" />
                <select id="rd_zender_type" name="radio_detection[zender_type]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                    <option value="Radiodetection TX10" @selected(old('radio_detection.zender_type')==='Radiodetection TX10')>Radiodetection TX10</option>
                    <option value="Vivax TX10" @selected(old('radio_detection.zender_type')==='Vivax TX10')>Vivax TX10</option>
                </select>
                <x-input-error :messages="$errors->get('radio_detection.zender_type')" class="mt-2" />
            </div>

            <!-- Conditional fields -->
            <div x-show="type==='Passief'">
                <x-input-label for="rd_sonde_type" value="Sonde type" />
                <select id="rd_sonde_type" name="radio_detection[sonde_type]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                    <option value="">-</option>
                    <option value="Rioolsonde" @selected(old('radio_detection.sonde_type')==='Rioolsonde')>Rioolsonde</option>
                    <option value="Joepert" @selected(old('radio_detection.sonde_type')==='Joepert')>Joepert</option>
                    <option value="Joekeloekie" @selected(old('radio_detection.sonde_type')==='Joekeloekie')>Joekeloekie</option>
                    <option value="Boorsonde" @selected(old('radio_detection.sonde_type')==='Boorsonde')>Boorsonde</option>
                </select>
                <x-input-error :messages="$errors->get('radio_detection.sonde_type')" class="mt-2" />
            </div>

            <div x-show="type==='Actief'">
                <x-input-label for="rd_geleider_frequentie" value="Geleider frequentie" />
                <select id="rd_geleider_frequentie" name="radio_detection[geleider_frequentie]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                    <option value="">-</option>
                    <option value="285hz" @selected(old('radio_detection.geleider_frequentie')==='285hz')>285hz</option>
                    <option value="320hz" @selected(old('radio_detection.geleider_frequentie')==='320hz')>320hz</option>
                    <option value="1khz" @selected(old('radio_detection.geleider_frequentie')==='1khz')>1khz</option>
                    <option value="4khz cd" @selected(old('radio_detection.geleider_frequentie')==='4khz cd')>4khz cd</option>
                    <option value="8khz" @selected(old('radio_detection.geleider_frequentie')==='8khz')>8khz</option>
                    <option value="8440khz" @selected(old('radio_detection.geleider_frequentie')==='8440khz')>8440khz</option>
                    <option value="33khz" @selected(old('radio_detection.geleider_frequentie')==='33khz')>33khz</option>
                </select>
                <x-input-error :messages="$errors->get('radio_detection.geleider_frequentie')" class="mt-2" />
            </div>
        </div>
    </div>
</div>
