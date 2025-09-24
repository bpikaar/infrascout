<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('report.title.pdf', ['id' => $report->id]) }} - {{ $report->project->name }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
            color: #222;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 32px;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 32px;
        }
        .header img {
            height: 96px;
            width: 96px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 32px;
        }
        .header h1 {
            font-size: 2rem;
            margin: 0 0 8px 0;
        }
        .section {
            border-top: 1px solid #e5e7eb;
            padding-top: 24px;
            margin-top: 24px;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 16px;
            color: #222;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }
        .grid-col {
            background: #f3f4f6;
            border-radius: 8px;
            padding: 16px;
            flex: 1 1 250px;
            min-width: 220px;
        }
        .images-row {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }
        .images-row img {
            height: 120px;
            width: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .description {
            background: #f3f4f6;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }
        .timestamps {
            display: flex;
            gap: 16px;
        }
        .timestamps .grid-col {
            min-width: 220px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>{{ __('report.title.show', ['id' => $report->id]) }}</h1>
                <p>{{ __('report.project.label') }}: {{ $report->project->name ?? __('report.status.n_a') }}</p>
                <p>{{ __('report.fields.work_date') }}: {{ $report->date_of_work->format('Y-m-d') }}</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">{{ __('report.title.details') }}</div>
            <div class="grid">
                <div class="grid-col">
                    <strong>{{ __('report.fields.project') }}</strong><br>
                    {{ $report->project->name ?? __('report.status.n_a') }}<br>
                    <span style="color: #555; font-size: 0.95em;">{{ __('report.project.number', ['number' => $report->project->number ?? __('report.status.n_a')]) }}</span>
                </div>
                <div class="grid-col">
                    <strong>{{ __('report.fields.date_of_work') }}</strong><br>
                    {{ $report->date_of_work->format('l, F j, Y') }}<br>
                    <span style="color: #555; font-size: 0.95em;">{{ $report->date_of_work->format('H:i') }}</span>
                </div>
                <div class="grid-col">
                    <strong>{{ __('report.fields.created_by') }}</strong><br>
                    {{ $report->user->name ?? 'N/A' }}<br>
                    <span style="color: #555; font-size: 0.95em;">{{ $report->user->email ?? 'N/A' }}</span>
                </div>
                <div class="grid-col">
                    <strong>{{ __('report.fields.field_worker') }}</strong><br>
                    {{ $report->fieldWorker->name ?? 'N/A' }}<br>
                    <span style="color: #555; font-size: 0.95em;">{{ $report->fieldWorker->email ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">{{ __('report.title.cables') }}</div>
            <div style="display:flex; flex-direction:column; gap:32px;">
                <div>
                    <strong style="display:block; margin-bottom:8px;">{{ __('report.title.cables_section') }}</strong>
                    @if($report->cables->count())
                        <div class="grid" style="flex-direction: column; gap:8px;">
                            @foreach($report->cables as $cable)
                                <div class="grid-col" style="display:flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <strong>{{ $cable->cable_type }}</strong>
                                        <span style="margin-left:8px;">{{ $cable->material }}</span>
                                        @if($cable->diameter)
                                            <span style="margin-left:8px;">{{ number_format($cable->diameter,2) }} mm</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color:#666; font-size:0.9em;">{{ __('report.cables.none') }}</p>
                    @endif
                </div>
                <div>
                    <strong style="display:block; margin-bottom:8px;">{{ __('report.title.pipes_section') }}</strong>
                    @if($report->pipes && $report->pipes->count())
                        <div class="grid" style="flex-direction: column; gap:8px;">
                            @foreach($report->pipes as $pipe)
                                <div class="grid-col" style="display:flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <strong>{{ $pipe->pipe_type }}</strong>
                                        <span style="margin-left:8px;">{{ $pipe->material }}</span>
                                        @if($pipe->diameter)
                                            <span style="margin-left:8px;">{{ number_format($pipe->diameter,2) }} mm</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color:#666; font-size:0.9em;">{{ __('report.pipes.none') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">{{ __('report.title.work') }}</div>
            <div class="grid">
                <div class="grid-col">
                    <strong>{{ __('report.fields.work_hours') }}</strong><br>
                    {{ $report->work_hours }}
                </div>
                <div class="grid-col">
                    <strong>{{ __('report.fields.travel_time') }}</strong><br>
                    {{ $report->travel_time }}
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">{{ __('report.title.description') }}</div>
            <div class="description">
                {{ $report->description }}
            </div>
        </div>

        @if($report->testTrench)
        <div class="section">
            <div class="section-title">Proefsleuf</div>
            <div class="grid">
                <div class="grid-col">
                    <strong>Proefsleuf gemaakt</strong><br>
                    {{ $report->testTrench->proefsleuf_gemaakt ? 'Ja' : 'Nee' }}
                </div>
                <div class="grid-col">
                    <strong>Manier van graven</strong><br>
                    {{ $report->testTrench->manier_van_graven }}
                </div>
                <div class="grid-col">
                    <strong>Type grondslag</strong><br>
                    {{ $report->testTrench->type_grondslag }}
                </div>
                <div class="grid-col">
                    <strong>KLIC melding gedaan</strong><br>
                    {{ $report->testTrench->klic_melding_gedaan ? 'Ja' : 'Nee' }}
                </div>
                <div class="grid-col">
                    <strong>KLIC nummer</strong><br>
                    {{ $report->testTrench->klic_nummer }}
                </div>
                <div class="grid-col" style="flex-basis:100%;">
                    <strong>Locatie</strong><br>
                    {{ $report->testTrench->locatie }}
                </div>
                <div class="grid-col">
                    <strong>Doel</strong><br>
                    {{ $report->testTrench->doel }}
                </div>
                <div class="grid-col" style="flex-basis:100%;">
                    <strong>Bevindingen</strong><br>
                    {{ $report->testTrench->bevindingen }}
                </div>
            </div>
        </div>
        @endif

        @if($report->groundRadar)
        <div class="section">
            <div class="section-title">Grondradar</div>
            <div class="grid">
                <div class="grid-col">
                    <strong>Onderzoeksgebied</strong><br>
                    {{ $report->groundRadar->onderzoeksgebied }}
                </div>
                <div class="grid-col">
                    <strong>Scanrichting</strong><br>
                    {{ $report->groundRadar->scanrichting }}
                </div>
                <div class="grid-col">
                    <strong>ingestelde detectiediepte (m)</strong><br>
                    {{ $report->groundRadar->ingestelde_detectiediepte }}
                </div>
                <div class="grid-col" style="flex-basis:100%;">
                    <strong>Reflecties / objecten</strong><br>
                    {{ $report->groundRadar->reflecties }}
                </div>
                <div class="grid-col">
                    <strong>Interpretatie</strong><br>
                    {{ $report->groundRadar->interpretatie }}
                </div>
            </div>
        </div>
        @endif

        @if($report->cableFailure)
        <div class="section">
            <div class="section-title">Kabelstoring</div>
            <div class="grid">
                <div class="grid-col">
                    <strong>Type storing</strong><br>
                    {{ $report->cableFailure->type_storing }}
                </div>
                <div class="grid-col">
                    <strong>Locatie storing</strong><br>
                    {{ $report->cableFailure->locatie_storing }}
                </div>
                <div class="grid-col">
                    <strong>Methode vaststelling</strong><br>
                    {{ $report->cableFailure->methode_vaststelling }}
                </div>
                <div class="grid-col">
                    <strong>Kabel met aftakking</strong><br>
                    {{ $report->cableFailure->kabel_met_aftakking ? 'Ja' : 'Nee' }}
                </div>
                @if($report->cableFailure->bijzonderheden)
                    <div class="grid-col" style="flex-basis:100%;">
                        <strong>Bijzonderheden</strong><br>
                        {{ $report->cableFailure->bijzonderheden }}
                    </div>
                @endif
                @if($report->cableFailure->advies)
                    <div class="grid-col" style="flex-basis:100%;">
                        <strong>Advies</strong><br>
                        {{ $report->cableFailure->advies }}
                    </div>
                @endif
            </div>
        </div>
        @endif

        <div class="section">
            <div class="section-title">{{ __('report.title.images') }}</div>
            @if($report->images && $report->images->count())
                <div class="images-row">
                    @foreach($report->images as $image)
                        @php
                            // Use the public/images symlink (see config/filesystems.php -> links)
                            $imgPath = public_path('images/reports/'.$report->id.'/'.$image->path);
                        @endphp
                        @if(file_exists($imgPath))
                            <img src="{{ $imgPath }}" alt="Report image" />
                        @endif
                    @endforeach
                </div>
            @else
                <p style="color: #888;">{{ __('report.images.none') }}</p>
            @endif
        </div>

        <div class="section">
            <div class="section-title">{{ __('report.title.timestamps') }}</div>
            <div class="timestamps">
                <div class="grid-col">
                    <strong>{{ __('report.fields.created_at') }}</strong><br>
                    {{ $report->created_at->format('Y-m-d H:i') }}
                </div>
                <div class="grid-col">
                    <strong>{{ __('report.fields.updated_at') }}</strong><br>
                    {{ $report->updated_at->format('Y-m-d H:i') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
