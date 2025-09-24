<div x-show="testTrenchEnabled" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('Proefsleuf') }}</h2>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{ klicMeldingGedaan: {{ old('test_trench.klic_melding_gedaan') ? 'true' : 'false' }} }">
        <div class="md:col-span-2">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="test_trench[proefsleuf_gemaakt]" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="text-gray-700 dark:text-gray-300">{{ __('Proefsleuf gemaakt') }}</span>
            </label>
        </div>

        <div>
            <x-input-label for="tt_manier_van_graven" value="Manier van graven" />
            <select id="tt_manier_van_graven" name="test_trench[manier_van_graven]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Mini-graver" @selected(old('test_trench.manier_van_graven')==='Mini-graver')>Mini-graver</option>
                <option value="Handmatig" @selected(old('test_trench.manier_van_graven')==='Handmatig')>Handmatig</option>
            </select>
            <x-input-error :messages="$errors->get('test_trench.manier_van_graven')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="tt_type_grondslag" value="Type grondslag" />
            <select id="tt_type_grondslag" name="test_trench[type_grondslag]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                <option value="">-</option>
                <option value="Zand" @selected(old('test_trench.type_grondslag')==='Zand')>Zand</option>
                <option value="Grond" @selected(old('test_trench.type_grondslag')==='Grond')>Grond</option>
                <option value="Klei" @selected(old('test_trench.type_grondslag')==='Klei')>Klei</option>
                <option value="Veen" @selected(old('test_trench.type_grondslag')==='Veen')>Veen</option>
            </select>
            <x-input-error :messages="$errors->get('test_trench.type_grondslag')" class="mt-2" />
        </div>

        <div class="col-span-2">
            <label class="inline-flex items-center space-x-2">
                <input
                    type="checkbox"
                    id="tt_klic_melding_gedaan"
                    name="test_trench[klic_melding_gedaan]"
                    value="1"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    x-model="klicMeldingGedaan"
                />
                <span class="text-gray-700 dark:text-gray-300">{{ __('KLIC-melding gedaan') }}</span>
            </label>
            <x-input-error :messages="$errors->get('test_trench.klic_melding_gedaan')" class="mt-2" />
        </div>
        <div x-show="klicMeldingGedaan" class="mt-4">
            <x-input-label for="tt_klic_nummer" value="KLIC-nummer" />
            <x-text-input id="tt_klic_nummer" name="test_trench[klic_nummer]" type="text" class="block mt-1 w-full" :value="old('test_trench.klic_nummer')" />
            <x-input-error :messages="$errors->get('test_trench.klic_nummer')" class="mt-2" />
        </div>
        <div x-show="klicMeldingGedaan" class="mt-4">
            <x-input-label for="tt_locatie" value="Locatie" />
            <textarea id="tt_locatie" name="test_trench[locatie]" rows="2" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('test_trench.locatie') }}</textarea>
            <x-input-error :messages="$errors->get('test_trench.locatie')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="tt_doel" value="Doel" />
            <x-text-input id="tt_doel" name="test_trench[doel]" type="text" class="block mt-1 w-full" :value="old('test_trench.doel')" />
            <x-input-error :messages="$errors->get('test_trench.doel')" class="mt-2" />
        </div>

        <div class="md:col-span-2">
            <x-input-label for="tt_bevindingen" value="Bevindingen" />
            <textarea id="tt_bevindingen" name="test_trench[bevindingen]" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('test_trench.bevindingen') }}</textarea>
            <x-input-error :messages="$errors->get('test_trench.bevindingen')" class="mt-2" />
        </div>
    </div>
</div>
