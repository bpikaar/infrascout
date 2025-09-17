<div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg" x-data="multiPipeManager(@js(old('pipes', [])))">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.pipes') }}</h2>
    <template x-for="(row, index) in rows" :key="row.uid">
        <div class="mb-4 border border-gray-200 dark:border-gray-600 rounded-md p-4 bg-white dark:bg-gray-800 relative">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search / Pipe Type -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" x-bind:for="'pipe_type_'+index">{{ __('report.fields.pipe_type') }}</label>
                    <input x-bind:id="'pipe_type_'+index"
                        type="text"
                        x-model="row.pipe_type"
                        x-bind:name="`pipes[${index}][pipe_type]`"
                        @focus="onFocus(index)"
                        @input.debounce.250ms="doSearch(index)"
                        @keydown.escape.stop.prevent="hide(index)"
                        @blur="onBlur(index, $event)"
                        placeholder="{{ __('report.placeholders.pipe_type') }}"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md" />
                    @if($errors->get('pipes.*'))
                        <x-input-error messages="Niet alle velden zijn goed ingevoerd" class="mt-2" />
                    @endif

                    <!-- Results dropdown -->
                    <div class="mt-1 bg-white dark:bg-gray-900 border dark:text-white border-gray-200 dark:border-gray-700 rounded shadow-md z-20" x-show="row.showResults" @mousedown.away="hide(index)" @keydown.escape.stop.prevent="hide(index)">
                        <template x-if="row.results.length === 0">
                            <div class="p-2 text-sm text-gray-500">{{ __('report.pipes.no_results') }}</div>
                        </template>
                        <template x-for="r in row.results" :key="r.id">
                            <button type="button" class="w-full text-left px-3 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm" @click="selectExisting(index, r)">
                                <span class="font-medium" x-text="r.pipe_type"></span>
                                <span class="text-xs text-gray-500 ml-1" x-text="r.material"></span>
                                <span class="text-xs text-gray-500 ml-1" x-text="r.diameter ? (r.diameter + ' mm') : ''"></span>
                            </button>
                        </template>
                    </div>
                </div>
                <!-- Materiaal -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" x-bind:for="'pipe_material_'+index">Materiaal</label>
                    <select x-bind:id="'pipe_material_'+index"
                            x-model="row.material"
                            x-bind:name="`pipes[${index}][material]`"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                        <option value="">-</option>
                        <option value="PVC">PVC</option>
                        <option value="HDPE">HDPE</option>
                        <option value="Steel">{{ __('report.pipes.material.steel') }}</option>
                        <option value="Copper">{{ __('report.pipes.material.copper') }}</option>
                    </select>
                </div>
                <!-- Diameter -->
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" x-bind:for="'pipe_diameter_'+index">Diameter (mm)</label>
                    <input x-bind:id="'pipe_diameter_'+index"
                           type="number" step="0.01"
                           x-model="row.diameter"
                           x-bind:name="`pipes[${index}][diameter]`"
                           class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md" />
                </div>
            </div>
            <button type="button" class="absolute top-2 right-2 text-2xl text-red-600 hover:text-red-800" x-show="rows.length > 1" @click="removeRow(index)">&times;</button>
            <!-- Hidden existing pipe id (blank for new) -->
            <input type="hidden" x-bind:name="`pipes[${index}][id]`" x-bind:value="row.id ? row.id : ''" />
        </div>
    </template>
    <div>
        <x-primary-button type="button" @click="addRow()">+ {{ __('report.pipes.add') }}</x-primary-button>
    </div>
</div>

@once('pipe-selector-scripts')
    @push('scripts')
        <script>
            function multiPipeManager(oldPipes = []) {
                return {
                    rows: (Array.isArray(oldPipes) && oldPipes.length) ? oldPipes.map(p => hydratePipeRow(p)) : [],
                    addRow() { this.rows.push(newPipeRow()); },
                    removeRow(index) { this.rows.splice(index,1); },
                    doSearch(index) {
                        const row = this.rows[index];
                        row.id = null;
                        const q = row.pipe_type.trim();
                        if(q === '' && row.loadedAll) { row.showResults = true; return; }
                        const url = q === '' ? `{{ route('pipes.search') }}` : `{{ route('pipes.search') }}?q=${encodeURIComponent(q)}`;
                        const token = ++row.requestToken;
                        fetch(url)
                            .then(r=>r.json())
                            .then(data => {
                                if(row.requestToken !== token) return;
                                row.results = data;
                                row.showResults = true;
                                if(q === '') row.loadedAll = true;
                            });
                    },
                    onFocus(index){
                        const row = this.rows[index];
                        if(!row.loadedAll){ this.doSearch(index); } else { row.showResults = true; }
                    },
                    hide(index){ const row = this.rows[index]; row.showResults = false; },
                    onBlur(index, evt){ setTimeout(()=>{ const row = this.rows[index]; if(!document.activeElement || !evt.currentTarget.parentElement.contains(document.activeElement)){ row.showResults=false; } },120); },
                    selectExisting(index, pipe) {
                        const row = this.rows[index];
                        row.id = pipe.id;
                        row.pipe_type = pipe.pipe_type;
                        row.material = pipe.material || '';
                        row.diameter = pipe.diameter || '';
                        row.results = []; row.showResults=false;
                    }
                }
            }
            function newPipeRow(){
                const uid = (window.crypto && crypto.randomUUID) ? crypto.randomUUID() : ('p_'+Date.now()+Math.random().toString(16).slice(2));
                return { uid, pipe_type:'', material:'', diameter:'', id:null, results:[], showResults:false, loadedAll:false, requestToken:0 };
            }
            function hydratePipeRow(p) {
                const r = newPipeRow();
                r.pipe_type = p.pipe_type || '';
                r.material = p.material || '';
                r.diameter = p.diameter || '';
                if (p.id) { r.id = p.id; }
                return r;
            }
        </script>
    @endpush
@endonce
