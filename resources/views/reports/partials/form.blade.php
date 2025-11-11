@php
    $mode = $mode ?? 'create'
@endphp

<!-- Shared form fields for create/edit -->
<!-- Project & basic details -->
<div class="bg-gray-200 dark:bg-gray-500 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.fields.project') }} / {{ __('report.title.details') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="project_id" :value="__('report.fields.project')" />
            <select id="project_id" name="project_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md" required>
                <option value="">{{ __('report.project.select') }}</option>
                @foreach($projects as $p)
                    <option value="{{ $p->id }}" @selected(old('project_id', $report->project_id ?? $project->id) == $p->id)>#{{ $p->number }} - {{ $p->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="date_of_work" :value="__('report.fields.date_of_work')" />
            <x-text-input id="date_of_work" type="datetime-local" name="date_of_work" class="block mt-1 w-full" :value="old('date_of_work', ($report->date_of_work ?? now())->format('Y-m-d\TH:i'))" required />
            <x-input-error :messages="$errors->get('date_of_work')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="field_worker" :value="__('report.fields.field_worker')" />
            <select id="field_worker" name="field_worker" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md" required>
                <option value="">{{ __('report.fields.field_worker') }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('field_worker', $report->field_worker ?? auth()->id()) == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('field_worker')" class="mt-2" />
        </div>
    </div>
</div>

<div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <x-input-label for="title" :value="__('report.fields.title')" />
    <x-text-input id="title" name="title" type="text" class="block mt-1 w-full" :value="old('title', $report->title ?? '')" required />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.work') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="work_hours" :value="__('report.fields.work_hours')" />
            <x-text-input id="work_hours" name="work_hours" type="text" class="block mt-1 w-full" :value="old('work_hours', $report->work_hours ?? '')" required />
            <x-input-error :messages="$errors->get('work_hours')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="travel_time" :value="__('report.fields.travel_time')" />
            <x-text-input id="travel_time" name="travel_time" type="text" class="block mt-1 w-full" :value="old('travel_time', $report->travel_time ?? '')" required />
            <x-input-error :messages="$errors->get('travel_time')" class="mt-2" />
        </div>
        <div class="md:col-span-2">
            <x-input-label for="description" :value="__('report.fields.description')" />
            <textarea id="description" name="description" rows="6" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md" required>{{ old('description', $report->description ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
    </div>
</div>

<!-- Cable & Pipe selectors could be refactored to accept existing items via props; reusing components for simplicity -->
<x-report.create.cable-selector />
<x-report.create.pipe-selector />

@php
    // Normalize to booleans so Alpine receives true/false consistently and @checked works for server-side rendering
    $radioEnabledOld = (bool) old('radio_detection_enabled', isset($report) && $report->radioDetection ? true : false);
    $gyroEnabledOld = (bool) old('gyroscope_enabled', isset($report) && $report->gyroscope ? true : false);
    $testTrenchEnabledOld = (bool) old('test_trench_enabled', isset($report) && $report->testTrench ? true : false);
    $groundRadarEnabledOld = (bool) old('ground_radar_enabled', isset($report) && $report->groundRadar ? true : false);
    $cableFailureEnabledOld = (bool) old('cable_failure_enabled', isset($report) && $report->cableFailure ? true : false);
    $gpsMeasurementEnabledOld = (bool) old('gps_measurement_enabled', isset($report) && $report->gpsMeasurement ? true : false);
    $lanceEnabledOld = (bool) old('lance_enabled', isset($report) && $report->lance ? true : false);
@endphp
<div x-data="{ radioEnabled: @json($radioEnabledOld), enabledGyroscope: @json($gyroEnabledOld), testTrenchEnabled: @json($testTrenchEnabledOld), groundRadarEnabled: @json($groundRadarEnabledOld), cableFailureEnabled: @json($cableFailureEnabledOld), gpsMeasurementEnabled: @json($gpsMeasurementEnabledOld), lanceEnabled: @json($lanceEnabledOld) }" class="space-y-6">
    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('report.title.work_performed') }}</h2>
        <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-6">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="radio_detection_enabled" x-model="radioEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('radio_detection_enabled', isset($report) && $report->radioDetection ? true : false)) />
                <span class="text-gray-700 dark:text-gray-300">Radiodetectie</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="gyroscope_enabled" x-model="enabledGyroscope" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('gyroscope_enabled', isset($report) && $report->gyroscope ? true : false)) />
                <span class="text-gray-700 dark:text-gray-300">Gyroscoopmeting</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="test_trench_enabled" x-model="testTrenchEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('test_trench_enabled', isset($report) && $report->testTrench ? true : false)) />
                <span class="text-gray-700 dark:text-gray-300">Proefsleuf</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="ground_radar_enabled" x-model="groundRadarEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('ground_radar_enabled', isset($report) && $report->groundRadar ? true : false)) />
                <span class="text-gray-700 dark:text-gray-300">Grondradar</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="cable_failure_enabled" x-model="cableFailureEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('cable_failure_enabled', isset($report) && $report->cableFailure ? true : false)) />
                <span class="text-gray-700 dark:text-gray-300">Kabelstoring</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="gps_measurement_enabled" x-model="gpsMeasurementEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('gps_measurement_enabled', isset($report) && $report->gpsMeasurement ? true : false)) />
                <span class="text-gray-700 dark:text-gray-300">GPS-meting</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="lance_enabled" x-model="lanceEnabled" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('lance_enabled', isset($report) && $report->lance ? true : false)) />
                <span class="text-gray-700 dark:text-gray-300">Aanlansen / aanprikken</span>
            </label>
        </div>
    </div>

    <x-report.create.radio-detection :report="$report" />
    <x-report.create.gyroscope :report="$report" />
    <x-report.create.test-trench :report="$report" />
    <x-report.create.ground-radar :report="$report" />
    <x-report.create.cable-failure :report="$report" />
    <x-report.create.gps-measurement :report="$report" />
    <x-report.create.lance :report="$report" />
</div>

<div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Resultaten & vervolg</h2>
    <div class="grid grid-cols-1 gap-4">
        <div>
            <x-input-label for="results_summary" value="Samenvatting resultaten" />
            <textarea id="results_summary" name="results_summary" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('results_summary', $report->results_summary ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('results_summary')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="advice" value="Advies / aanbevelingen" />
            <textarea id="advice" name="advice" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('advice', $report->advice ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('advice')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="follow_up" value="Vervolgacties" />
            <textarea id="follow_up" name="follow_up" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">{{ old('follow_up', $report->follow_up ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('follow_up')" class="mt-2" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="problem_solved" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('problem_solved', $report->problem_solved ?? false)) />
                <span class="text-gray-700 dark:text-gray-300">Probleem opgelost</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="question_answered" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('question_answered', $report->question_answered ?? false)) />
                <span class="text-gray-700 dark:text-gray-300">Vraag opdrachtgever beantwoord</span>
            </label>
        </div>
    </div>
</div>
