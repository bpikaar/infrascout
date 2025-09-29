<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Rapport {{ $report->id }} - {{ $report->project->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
          /* Reset / base */
          *{margin:0;padding:0;}
          /* Use only built-in core fonts for Dompdf (Helvetica/Arial) to avoid embedding complexity */
          body{font-family:Helvetica, Arial, 'Liberation Sans', sans-serif;font-size:12px;line-height:1.4;color:#111;}
          /* Force generic sans-serif for h1 with !important to prevent Dompdf bold substitution to Times */
          /* h1 color set for diagnostic; remove or adjust to brand color as needed */
          /* Brand heading color */
          h1{font-family:sans-serif;font-size:24px;color:#21abde;}
          h2.section-title,h3.block-title{font-family:sans-serif, Arial, 'Liberation Sans';}
          h2.section-title{font-size:14px;letter-spacing:.5px;text-transform:uppercase;color:#555;}
          h3.block-title{font-size:13px;}
        img{border:0;max-width:100%;}
        table{border-collapse:collapse;width:100%;}
        th,td{vertical-align:top;}

        /* Layout containers */
        .page{padding:32px;size: 21cm 29.7cm;margin: 0;}
        .header-table{width:100%;}
        .header-left{width:55%;}
        .right{text-align:right;}

        /* Text helpers */
        .text-muted{font-family:sans-serif;}
        .text-small{font-size:11px;color:#555;}
        .pre{white-space:pre-line;}
        /*.fw-600{font-weight:600;}*/
        .upper{letter-spacing:.5px;text-transform:uppercase;}

        /* Spacing utilities */
        .mb-2{margin-bottom:2px;}
        .mb-4{margin-bottom:4px;}
        .mb-6{margin-bottom:6px;}
        .mb-8{margin-bottom:8px;}
        .mb-12{margin-bottom:12px;}
        .mb-16{margin-bottom:16px;}
        .mb-18{margin-bottom:18px;}
        .mb-24{margin-bottom:24px;}
        .mb-28{margin-bottom:28px;}

        .page-break{ page-break-before: always; }
        /* Blocks / panels */
        .panel{background:#f3f4f6;padding:16px;border-radius:6px;}
        .panel--compact{padding:12px;}
        .card-table{border:1px solid #d9d9d9;border-radius:6px;overflow:hidden;}
        .card-table td{padding:16px;}
        .split{border-right:1px solid #e2e2e2;}
        .subhead {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
        }

        /* Badges */
        .badge{display:inline-block;padding:2px 6px;border-radius:4px;font-size:10px;color:#fff;}
        .badge-yes{background:#15803d;}
        .badge-no{background:#b91c1c;}

        /* Key/Value tables */
        .kv{width:100%;font-size:11px;border:1px solid #dcdcdc;margin-bottom:18px;}
        .kv:last-child{margin-bottom:0;}
        .kv th{background:#f3f4f6;text-align:left;padding:6px 8px;width:170px;}
        .kv td{padding:6px 8px;}
        .kv--tight{margin-bottom:12px;}

        /* Data list tables (striped) */
        .striped{width:100%;font-size:11px;border:1px solid #dcdcdc;margin-bottom:18px;}
        .striped thead th{background:#f3f4f6;padding:6px 8px;text-align:left;border-bottom:1px solid #dcdcdc;}
        .striped td{padding:6px 8px;}
        .striped tbody tr:nth-child(even){background:#f9fafb;}
        .striped:last-child{margin-bottom:0;}

        /* Images */
        .images-wrapper{margin-bottom:4px;}
        .report-image{
            border:1px solid #ccc;
            border-radius:4px;
            max-width:480px;
            max-height:320px;
            width:auto;
            height:auto;
            margin:0 8px 8px 0;
            display:inline-block;
        }

        /* Metadata */
        .meta-table{width:100%;font-size:11px;border:1px solid #dcdcdc;margin-bottom:6px;}
        .meta-table th{background:#f3f4f6;text-align:left;padding:6px 8px;width:170px;}
        .meta-table td{padding:6px 8px;}
        .footer-note{font-size:10px;color:#666;}

        /* States */
        .no-data{font-size:11px;color:#666;margin-bottom:14px;}

        /* Logo */
        .logo{height:50px;display:block;margin-bottom:16px;}
    </style>
</head>
<body>
<div class="page">

    {{-- Header --}}
    <table class="header-table mb-28">
        <tr>
            <td class="header-left">
                @php
                    $logoPath = public_path('images/static/logo-infrascout.png');
                @endphp
                @if(file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Infrascout" class="logo">
                @endif
                <h1 class="mb-4">Werkrapport</h1>
            </td>
            <td class="right">
                <div class="text-small mb-2">Datum rapport: {{ now()->format('d-m-Y') }}</div>
            </td>
        </tr>
    </table>

    {{-- Core information --}}
    <table class="card-table mb-28">
        <tr>
            <td class="split">
                <div class="subhead upper">Project</div>
                <div class="mb-4"><strong>Naam:</strong> {{ $report->project->name }}</div>
                <div class="mb-4"><strong>Nummer:</strong> {{ $report->project->number }}</div>
                <div class="mb-4"><strong>Uitvoerder:</strong> {{ $report->fieldWorker->name }} (<a href="mailto: {{ $report->fieldWorker->email }} ">{{ $report->fieldWorker->email }}</a>)</div>

                <div><strong>Datum werk:</strong> {{ $report->date_of_work->format('d-m-Y H:i') }}</div>
            </td>
            <td>
                <div class="subhead upper">Medewerker</div>
                <div class="mb-4"><strong>Uitvoerder:</strong> </div>

            </td>
        </tr>
        <tr>
            <td class="split">
                <div class="subhead upper">Tijden</div>
                <div class="mb-4"><strong>Werkuren:</strong> {{ $report->work_hours }}</div>
                <div class="mb-4"><strong>Reistijd:</strong> {{ $report->travel_time }}</div>
            </td>
            <td>
                <div class="subhead upper">Status</div>
                <div class="mb-6">
                    <strong>Probleem opgelost:</strong>
                    <span class="badge {{ $report->problem_solved ? 'badge-yes':'badge-no' }}">{{ $report->problem_solved ? 'Ja':'Nee' }}</span>
                </div>
                <div>
                    <strong>Vraag opdrachtgever beantwoord:</strong>
                    <span class="badge {{ $report->question_answered ? 'badge-yes':'badge-no' }}">{{ $report->question_answered ? 'Ja':'Nee' }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- Description --}}
    <div class="mb-28">
        <h2 class="section-title mb-12">Omschrijving opdracht</h2>
        <div class="panel pre">{{ $report->description }}</div>
    </div>

    {{-- Cables & Pipes --}}
    <div class="mb-28">
        <h2 class="section-title mb-12">Kabels &amp; Leidingen</h2>

        <h3 class="block-title mb-4">Kabels</h3>
        @if($report->cables->count())
            <table class="striped mb-18">
                <thead>
                <tr>
                    <th>Type</th><th>Materiaal</th><th>Diameter (mm)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($report->cables as $c)
                    <tr>
                        <td>{{ $c->cable_type }}</td>
                        <td>{{ $c->material }}</td>
                        <td>{{ $c->diameter ? number_format($c->diameter,2) : '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Geen kabels geregistreerd.</div>
        @endif

        <h3 class="block-title mb-4">Leidingen</h3>
        @if($report->pipes->count())
            <table class="striped">
                <thead>
                <tr>
                    <th>Type</th><th>Materiaal</th><th>Diameter (mm)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($report->pipes as $p)
                    <tr>
                        <td>{{ $p->pipe_type }}</td>
                        <td>{{ $p->material }}</td>
                        <td>{{ $p->diameter ? number_format($p->diameter,2) : '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Geen leidingen geregistreerd.</div>
        @endif
    </div>

    {{-- Executed Work --}}
    @if($report->radioDetection || $report->gyroscope || $report->testTrench || $report->groundRadar || $report->cableFailure || $report->gpsMeasurement)
        <div class="mb-28">
            <h2 class="section-title mb-12">Uitgevoerde werkzaamheden</h2>

            @if($report->radioDetection)
                <div class="mb-18">
                    <h3 class="block-title mb-4">Radiodetectie</h3>
                    <table class="kv">
                        <tbody>
                        <tr><th>Signaal op kabel</th><td>{{ $report->radioDetection->signaal_op_kabel }}</td></tr>
                        <tr><th>Signaal sterkte</th><td>{{ $report->radioDetection->signaal_sterkte }}</td></tr>
                        <tr><th>Frequentie</th><td>{{ $report->radioDetection->frequentie }}</td></tr>
                        <tr><th>Aansluiting</th><td>{{ $report->radioDetection->aansluiting }}</td></tr>
                        <tr><th>Zender type</th><td>{{ $report->radioDetection->zender_type }}</td></tr>
                        @if($report->radioDetection->sonde_type)
                            <tr><th>Sonde type</th><td>{{ $report->radioDetection->sonde_type }}</td></tr>
                        @endif
                        @if($report->radioDetection->geleider_frequentie)
                            <tr><th>Geleider frequentie</th><td>{{ $report->radioDetection->geleider_frequentie }}</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            @endif

            @if($report->groundRadar)
                <div class="mb-18">
                    <h3 class="block-title mb-4">Grondradar</h3>
                    <table class="kv">
                        <tbody>
                        <tr><th>Radarbeeld</th><td>{{ $report->groundRadar->radarbeeld }}</td></tr>
                        <tr><th>Ingestelde detectiediepte</th><td>{{ $report->groundRadar->ingestelde_detectiediepte }}</td></tr>
                        </tbody>
                    </table>
                </div>
            @endif

            @if($report->gyroscope)
                <div class="mb-18">
                    <h3 class="block-title mb-4">Gyroscoopmeting</h3>
                    <table class="kv">
                        <tbody>
                        <tr><th>Type boring</th><td>{{ $report->gyroscope->type_boring }}</td></tr>
                        <tr><th>Intredepunt</th><td>{{ $report->gyroscope->intredepunt }}</td></tr>
                        <tr><th>Uittredepunt</th><td>{{ $report->gyroscope->uittredepunt }}</td></tr>
                        <tr><th>Lengte tracé (m)</th><td>{{ $report->gyroscope->lengte_trace }}</td></tr>
                        <tr><th>Bodemprofiel GPS</th><td>{{ $report->gyroscope->bodemprofiel_ingemeten_met_gps ? 'Ja':'Nee' }}</td></tr>
                        <tr><th>Diameter buis (mm)</th><td>{{ $report->gyroscope->diameter_buis }}</td></tr>
                        <tr><th>Materiaal</th><td>{{ $report->gyroscope->materiaal }}</td></tr>
                        <tr><th>Ingemeten met</th><td>{{ $report->gyroscope->ingemeten_met }}</td></tr>
                        @if($report->gyroscope->bijzonderheden)
                            <tr><th>Bijzonderheden</th><td class="pre">{{ $report->gyroscope->bijzonderheden }}</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            @endif

            @if($report->testTrench)
                <div class="mb-18">
                    <h3 class="block-title mb-4">Proefsleuf</h3>
                    <table class="kv">
                        <tbody>
                        <tr><th>Proefsleuf gemaakt</th><td>{{ $report->testTrench->proefsleuf_gemaakt ? 'Ja':'Nee' }}</td></tr>
                        <tr><th>Manier van graven</th><td>{{ $report->testTrench->manier_van_graven }}</td></tr>
                        <tr><th>Type grondslag</th><td>{{ $report->testTrench->type_grondslag }}</td></tr>
                        <tr><th>KLIC melding gedaan</th><td>{{ $report->testTrench->klic_melding_gedaan ? 'Ja':'Nee' }}</td></tr>
                        <tr><th>KLIC nummer</th><td>{{ $report->testTrench->klic_nummer }}</td></tr>
                        <tr><th>Locatie</th><td>{{ $report->testTrench->locatie }}</td></tr>
                        <tr><th>Doel</th><td>{{ $report->testTrench->doel }}</td></tr>
                        <tr><th>Bevindingen</th><td class="pre">{{ $report->testTrench->bevindingen }}</td></tr>
                        </tbody>
                    </table>
                </div>
            @endif

            @if($report->cableFailure)
                <div class="mb-18">
                    <h3 class="block-title mb-4">Kabelstoring</h3>
                    <table class="kv">
                        <tbody>
                        <tr><th>Type storing</th><td>{{ $report->cableFailure->type_storing }}</td></tr>
                        <tr><th>Locatie storing</th><td>{{ $report->cableFailure->locatie_storing }}</td></tr>
                        <tr><th>Methode vaststelling</th><td>{{ $report->cableFailure->methode_vaststelling }}</td></tr>
                        <tr><th>Kabel met aftakking</th><td>{{ $report->cableFailure->kabel_met_aftakking ? 'Ja':'Nee' }}</td></tr>
                        @if($report->cableFailure->bijzonderheden)
                            <tr><th>Bijzonderheden</th><td class="pre">{{ $report->cableFailure->bijzonderheden }}</td></tr>
                        @endif
                        @if($report->cableFailure->advies)
                            <tr><th>Advies</th><td class="pre">{{ $report->cableFailure->advies }}</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            @endif

            @if($report->gpsMeasurement)
                <div class="mb-18">
                    <h3 class="block-title mb-4">GPS-meting</h3>
                    <table class="kv">
                        <tbody>
                        <tr><th>Gemeten met</th><td>{{ $report->gpsMeasurement->gemeten_met }}</td></tr>
                        <tr><th>Data verstuurd naar tekenaar</th><td>{{ $report->gpsMeasurement->data_verstuurd_naar_tekenaar ? 'Ja':'Nee' }}</td></tr>
                        <tr><th>Signaal</th><td>{{ $report->gpsMeasurement->signaal }}</td></tr>
                        <tr><th>Omgeving</th><td>{{ $report->gpsMeasurement->omgeving }}</td></tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    {{-- Findings / Results --}}
    <div class="mb-28 mt-10 page-break">
        <h2 class="section-title mb-12">Bevindingen werkzaamheden</h2>
        @if($report->results_summary)
            <div class="mb-16">
                <h3 class="section-title mb-12">Samenvatting resultaten</h3>
                <div class="panel panel--compact pre">{{ $report->results_summary }}</div>
            </div>
        @endif
        @if($report->advice)
            <div class="mb-16">
                <h3 class="section-title mb-12">Advies / aanbevelingen</h3>
                <div class="panel panel--compact pre">{{ $report->advice }}</div>
            </div>
        @endif
        @if($report->follow_up)
            <div>
                <h3 class="section-title mb-12">Vervolgacties</h3>
                <div class="panel panel--compact pre">{{ $report->follow_up }}</div>
            </div>
        @endif
    </div>

    {{-- Images --}}
    <div class="mb-28 page-break">
        <h2 class="section-title mb-12">Afbeeldingen</h2>
        @if($report->images && $report->images->count())
            <div class="images-wrapper">
                @foreach($report->images as $image)
                    @php $path = public_path('images/reports/'.$report->id.'/'.$image->path); @endphp
                    @if(file_exists($path))
                        <img src="{{ $path }}" alt="Afbeelding" class="report-image">
                    @endif
                @endforeach
            </div>
        @else
            <div class="no-data">Geen afbeeldingen toegevoegd.</div>
        @endif
        <div class="footer-note">
            Dit rapport is automatisch gegenereerd op {{ now()->format('d-m-Y H:i') }}.
        </div>
    </div>

</div>
</body>
</html>
