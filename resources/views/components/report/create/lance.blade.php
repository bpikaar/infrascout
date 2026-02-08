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
</div>
