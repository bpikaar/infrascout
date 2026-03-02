<div x-show="lanceEnabled" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Aanlansen / aanprikken</h2>

    <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\Lance::description() }}</p>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="lance_aanprikdiepte" value="aanprikdiepte (m)" />
            <x-text-input id="lance_aanprikdiepte" name="lance[aanprikdiepte]" type="number" step="0.01" class="block mt-1 w-full" :value="old('lance.aanprikdiepte', $report->lance->aanprikdiepte ?? '')" />
            <x-input-error :messages="$errors->get('lance.aanprikdiepte')" class="mt-2" />
        </div>
    </div>

    @php
        $isGrondChecked = function ($grondType) use ($report) {
            $oldGrond = old('lance.grond', []);
            if (!empty($oldGrond)) {
                return in_array($grondType, $oldGrond);
            }
            if (!empty($report->lance->description)) {
                return str_contains($report->lance->description, $grondType);
            }
            return false;
        };
    @endphp

    <div class="mt-4 flex flex-wrap items-center gap-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="lance[grond_aanwezig]" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('lance.grond_aanwezig', !empty($report->lance->description) ? 1 : 0))>
            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">De grond bestaat uit:</span>
        </label>
        <div class="flex items-center space-x-4">
            @foreach(['zand', 'klei', 'steen'] as $type)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="lance[grond][]" value="{{ $type }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked($isGrondChecked($type))>
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $type }}</span>
                </label>
            @endforeach
        </div>
        <x-input-error :messages="$errors->get('lance.description')" class="mt-2" />
    </div>

    <div class="mt-4 flex flex-wrap items-center gap-4">
        <x-report.create.method-image-upload id="lance_images" name="method_images[{{ \App\Enums\MethodType::Lance->value }}][]" label="Afbeeldingen Aanlansen / aanprikken" />
    </div>
</div>
