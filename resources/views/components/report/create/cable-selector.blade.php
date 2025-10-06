<div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg" x-data="multiCableManager(@js(old('cables', [])))">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.cables') }}</h2>
    <template x-for="(row, index) in rows" :key="row.uid">
        <div class="mb-4 border border-gray-200 dark:border-gray-600 rounded-md p-4 bg-white dark:bg-gray-800 relative">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search / Kabel Type -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" x-bind:for="'cable_type_'+index">{{ __('report.fields.cable_type') }}</label>
                    <input x-bind:id="'cable_type_'+index"
                        type="text"
                        x-model="row.cable_type"
                        x-bind:name="`cables[${index}][cable_type]`"
                        @focus="onFocus(index)"
                        @input.debounce.250ms="doSearch(index)"
                        @keydown.escape.stop.prevent="hide(index)"
                        @blur="onBlur(index, $event)"
                        placeholder="{{ __('report.placeholders.cable_type') }}"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md" />
                    @if($errors->get('cables.*'))
                        <x-input-error messages="Niet alle velden zijn goed ingevoerd" class="mt-2" />
                    @endif

                    <!-- Results dropdown -->
                    <div class="mt-1 bg-white dark:bg-gray-900 border dark:text-white border-gray-200 dark:border-gray-700 rounded shadow-md z-20" x-show="row.showResults" @mousedown.away="hide(index)" @keydown.escape.stop.prevent="hide(index)">
                        <template x-if="row.results.length === 0">
                            <div class="p-2 text-sm text-gray-500">{{ __('report.cables.no_results') }}</div>
                        </template>
                        <template x-for="r in row.results" :key="r.id">
                            <button type="button" class="w-full text-left px-3 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm" @click="selectExisting(index, r)">
                                <span class="font-medium" x-text="r.cable_type"></span>
                                <span class="text-xs text-gray-500 ml-1" x-text="r.material"></span>
                                <span class="text-xs text-gray-500 ml-1" x-text="r.diameter ? (r.diameter + ' mm') : ''"></span>
                            </button>
                        </template>
                    </div>
                </div>
                <!-- Materiaal -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" x-bind:for="'material_'+index">Materiaal</label>
                    <select x-bind:id="'material_'+index"
                            x-model="row.material"
                            x-bind:name="`cables[${index}][material]`"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                        <option value="">-</option>
                        <option value="GPLK">GPLK</option>
                        <option value="XLPE">XLPE</option>
                        <option value="Kunststof">{{ __('report.cables.material.plastic') }}</option>
                    </select>
                </div>
                <!-- Diameter -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" x-bind:for="'diameter_'+index">Diameter (mm)</label>
                    <input x-bind:id="'diameter_'+index"
                           type="number" step="0.01"
                           x-model="row.diameter"
                           x-bind:name="`cables[${index}][diameter]`"
                           class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md" />
                </div>
            </div>
            <button type="button" class="absolute top-2 right-2 text-2xl text-red-600 hover:text-red-800" x-show="rows.length > 1" @click="removeRow(index)">&times;</button>
            <!-- Hidden existing cable id (blank for new) -->
            <input type="hidden" x-bind:name="`cables[${index}][id]`" x-bind:value="row.id ? row.id : ''" />
        </div>
    </template>
    <div>
        <x-primary-button type="button" @click="addRow()">+ {{ __('report.cables.add') }}</x-primary-button>
    </div>
</div>

@once('cable-selector-scripts')
    @push('scripts')
        <script>
            function multiCableManager(oldCables = []) {
                return {
                    rows: (Array.isArray(oldCables) && oldCables.length) ? oldCables.map(c => hydrateRow(c)) : [],
                    addRow() { this.rows.push(newRow()); },
                    removeRow(index) { this.rows.splice(index,1); },
                    doSearch(index) {
                        const row = this.rows[index];
                        row.id = null;
                        const q = row.cable_type.trim();
                        // If empty and already loaded all once, just re-show.
                        if(q === '' && row.loadedAll) { row.showResults = true; return; }
                        const url = q === '' ? `{{ route('cables.search') }}` : `{{ route('cables.search') }}?q=${encodeURIComponent(q)}`;
                        const token = ++row.requestToken; // sequence guard
                        fetch(url)
                            .then(r=>r.json())
                            .then(data => {
                                if(row.requestToken !== token) return; // stale response
                                row.results = data;
                                row.showResults = true;
                                if(q === '') row.loadedAll = true;
                            });
                    },
                    onFocus(index) {
                        const row = this.rows[index];
                        if(!row.loadedAll) {
                            this.doSearch(index); // will fetch all
                        } else {
                            row.showResults = true;
                        }
                    },
                    hide(index){
                        const row = this.rows[index];
                        row.showResults = false;
                    },
                    onBlur(index, evt){
                        // Delay to allow click selection inside dropdown before hiding
                        setTimeout(() => {
                            const row = this.rows[index];
                            if(!document.activeElement || !evt.currentTarget.parentElement.contains(document.activeElement)) {
                                row.showResults = false;
                            }
                        }, 120);
                    },
                    selectExisting(index, cable) {
                        const row = this.rows[index];
                        row.id = cable.id;
                        row.cable_type = cable.cable_type;
                        row.material = cable.material || '';
                        row.diameter = cable.diameter || '';
                        row.results = []; row.showResults=false;
                    }
                }
            }
            function newRow(){
                const uid = (window.crypto && crypto.randomUUID) ? crypto.randomUUID() : ('c_'+Date.now()+Math.random().toString(16).slice(2));
                return { uid, cable_type:'', material:'', diameter:'', id:null, results:[], showResults:false, loadedAll:false, requestToken:0 };
            }
            function hydrateRow(c) {
                const r = newRow();
                r.cable_type = c.cable_type || '';
                r.material = c.material || '';
                r.diameter = c.diameter || '';
                // Only keep id if it came back and user had selected existing cable
                if (c.id) { r.id = c.id; }
                return r;
            }
        </script>
    @endpush
@endonce
