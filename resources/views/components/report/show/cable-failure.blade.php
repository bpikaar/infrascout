@props(['report'])

@if($report->cableFailure)
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Kabelstoring') }}</h3>

        <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line bg-white/70 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-600 rounded-md p-3">{{ \App\Models\CableFailure::description() }}</p>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-report.show.info-item header="Type storing" :p="$report->cableFailure->type_storing" />
            <x-report.show.info-item header="Locatie storing" :p="$report->cableFailure->locatie_storing" />
            <x-report.show.info-item header="Kabel met aftakking" :p="$report->cableFailure->kabel_met_aftakking ? 'Ja' : 'Nee'" />
            <div class="md:col-span-2 mt-4">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Methode vaststelling</h4>
                <div class="space-y-4 bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <!-- A-frame -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" disabled class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 disabled:opacity-100" @checked($report->cableFailure->a_frame)>
                        </div>
                        <div class="ms-2 text-sm opacity-100">
                            <label class="font-medium text-gray-900 dark:text-gray-300">A-frame</label>
                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400 whitespace-pre-line mt-1">{{ \App\Models\MethodDescription::where('method_type', \App\Enums\MethodType::AFrame->value)->value('description') }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4 bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <!-- TDR -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" disabled class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 disabled:opacity-100" @checked($report->cableFailure->tdr)>
                        </div>
                        <div class="ms-2 text-sm opacity-100">
                            <label class="font-medium text-gray-900 dark:text-gray-300">TDR</label>
                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400 whitespace-pre-line mt-1">{{ \App\Models\MethodDescription::where('method_type', \App\Enums\MethodType::TDR->value)->value('description') }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4 bg-white dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                    <!-- Isolatieweerstandmeting -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" disabled class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 disabled:opacity-100" @checked($report->cableFailure->isolatieweerstandmeting)>
                        </div>
                        <div class="ms-2 text-sm opacity-100">
                            <label class="font-medium text-gray-900 dark:text-gray-300">Isolatieweerstandmeting (Meggeren)</label>
                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400 whitespace-pre-line mt-1">{{ \App\Models\MethodDescription::where('method_type', \App\Enums\MethodType::Meggeren->value)->value('description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <x-report.show.info-item header="Bijzonderheden" :p="$report->cableFailure->bijzonderheden" pre="true" colspan="md:col-span-2" />
            <x-report.show.info-item header="Advies" :p="$report->cableFailure->advies" pre="true" colspan="md:col-span-2" />
        </div>

        <x-report.show.method-images :images="$report->images->where('method', \App\Enums\MethodType::CableFailure)" :reportId="$report->id" />
    </div>
@endif