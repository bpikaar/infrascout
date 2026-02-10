<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Rapport {{ $report->id }} - {{ $report->project->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Base Styling */
        @page {
            /* Dit zorgt voor ruimte op ELKE pagina, inclusief pagina 2, 3, etc. */
            margin-top: 2cm;
            margin-bottom: 1cm;
            margin-left: 1.75cm;
            margin-right: 1.75cm;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            color: #222;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        h1 { font-size: 26px; color: #21abde; text-transform: uppercase; margin-bottom: 5px; }
        h2 { font-size: 16px; color: #555; text-transform: uppercase; border-bottom: 2px solid #eee; padding-bottom: 5px; margin-bottom: 15px; letter-spacing: 0.5px; }
        h3 { font-size: 14px; color: #444; margin-bottom: 8px; border-left: 3px solid #21abde; padding-left: 8px; }
        p { margin-bottom: 12px; }
        strong { font-weight: bold; color: #222; }

        /* Layout */
        .page {
            /*padding: 40px 50px 80px 50px; !* Bottom padding for footer *!*/
            position: relative;
        }
        .page-break { page-break-after: always; }
        .row { width: 100%; }
        .col-half { width: 50%; vertical-align: top; }
        .col-quarter { width: 25%; vertical-align: top; }

        /* Component: Header */
        .header {
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 3px solid #f0f0f0;
            padding-bottom: 20px;
        }
        .logo { height: 60px; display: block; margin-bottom: 15px; }
        .report-meta { text-align: right; font-size: 11px; color: #777; }

        /* Component: Tables */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px 10px; text-align: left; vertical-align: top; font-size: 12px; }

        /* Key-Value Table */
        .kv-table td { border-bottom: 1px solid #f0f0f0; }
        .kv-table th { width: 160px; color: #666; font-weight: normal; border-bottom: 1px solid #f0f0f0; }
        .kv-table tr:last-child th, .kv-table tr:last-child td { border-bottom: none; }

        /* Data Table (Striped) */
        .data-table thead th {
            background-color: #21abde;
            color: #fff;
            font-weight: bold;
            padding: 8px 10px;
            border-bottom: 2px solid #1a8ab3;
        }
        .data-table tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .data-table td { border-bottom: 1px solid #eee; }

        /* Component: Panels */
        .panel {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            white-space: pre-wrap; /* Preserve newlines */
            font-family: inherit;
        }

        /* Component: Footer */
        .footer {
            position: fixed;
            bottom: 25px;
            left: 10px;
            right: 10px;
            height: 30px;
            border-top: 1px solid #eee;
            padding-top: 10px;
            font-size: 10px;
            color: #999;
            width: auto;
        }
        .footer-table { width: 100%; margin: 0; }
        .footer-left { text-align: left; }
        .footer-right { text-align: right; }
        .page-number:after { content: counter(page); }

        /* Utilities */
        .text-right { text-align: right; }
        .text-muted { color: #777; }
        .mb-0 { margin-bottom: 0; }
        .mt-4 { margin-top: 20px; }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            color: #fff;
        }
        .badge-yes { background-color: #28a745; }
        .badge-no { background-color: #dc3545; }

        /* Images */
        .image-gallery { margin-top: 10px; }
        .gallery-item {
            display: inline-block;
            width: 48%;
            margin-bottom: 15px;
            margin-right: 2%;
            vertical-align: top;
            text-align: center;
        }
        .gallery-item:nth-child(2n) { margin-right: 0; }
        .report-image {
            max-width: 100%;
            height: auto;
            border: 1px solid #eee;
            border-radius: 4px;
        }
        .no-data { font-style: italic; color: #888; padding: 10px 0; }
    </style>
</head>
<body>

    {{-- Footer (Appears on every page) --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td class="footer-left">Infrascout Rapportage | {{ $report->project->name }}</td>
                <td class="footer-right">Pagina <span class="page-number"></span></td>
            </tr>
        </table>
    </div>

    {{-- Content --}}
    <div class="page">
        {{-- Header Section --}}
        <table class="header">
            <tr>
                <td style="vertical-align: middle;">
                    @php
                        $logoPath = public_path('storage/images/static/logo-infrascout.png');
                    @endphp
                    @if(file_exists($logoPath))
                        <img src="{{ $logoPath }}" alt="Infrascout" class="logo">
                    @endif
                </td>
                <td style="vertical-align: middle; text-align: right;">
                    <h1>Werkrapport</h1>
                    <div class="text-muted" style="font-size: 16px;">{{ $report->title }}</div>
                    <div class="mt-4 text-muted" style="font-size: 12px;">Datum waarop rapport is aangemaakt: {{ now()->format('d-m-Y') }}</div>
                </td>
            </tr>
        </table>

        {{-- Project Details Section --}}
        <h2>Projectinformatie</h2>
        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                {{-- Left Column: Project --}}
                <td class="col-half" style="padding-right: 20px;">
                    <h3>Project</h3>
                    <table class="kv-table">
                        <tr><th>Projectnaam</th><td>{{ $report->project->name }}</td></tr>
                        <tr><th>Projectnummer</th><td>{{ $report->project->number }}</td></tr>
                        <tr><th>Datum werk</th><td>{{ $report->date_of_work->format('d-m-Y') }}</td></tr>
                    </table>
                </td>
                {{-- Right Column: Execution --}}
                <td class="col-half" style="padding-left: 20px;">
                    <h3>Uitvoering</h3>
                    <table class="kv-table">
                        <tr><th>Uitvoerder</th><td>{{ $report->fieldWorker->name }}</td></tr>
                        <tr><th>Email</th><td>{{ $report->fieldWorker->email }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Description --}}
        <h2>Omschrijving Opdracht</h2>
        <div class="panel">{{ $report->description }}</div>

        {{-- Cables & Pipes Section --}}
        <h2>Kabels &amp; Leidingen</h2>

        <h3>Kabels</h3>
        @if($report->cables->count())
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 40%">Type</th>
                        <th style="width: 30%">Materiaal</th>
                        <th style="width: 30%">Diameter (mm)</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($report->cables as $c)
                    <tr>
                        <td>{{ $c->cable_type }}</td>
                        <td>{{ $c->material }}</td>
                        <td>{{ $c->diameter ? number_format($c->diameter, 2, ',', '.') : '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Geen kabels geregistreerd.</div>
        @endif

        <div style="height: 20px;"></div> {{-- Spacer --}}

        <h3>Leidingen</h3>
        @if($report->pipes->count())
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 40%">Type</th>
                        <th style="width: 30%">Materiaal</th>
                        <th style="width: 30%">Diameter (mm)</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($report->pipes as $p)
                    <tr>
                        <td>{{ $p->pipe_type }}</td>
                        <td>{{ $p->material }}</td>
                        <td>{{ $p->diameter ? number_format($p->diameter, 2, ',', '.') : '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Geen leidingen geregistreerd.</div>
        @endif

        {{-- Measurements / Executed Work--}}
        @if($report->radioDetection || $report->gyroscope || $report->testTrench || $report->groundRadar || $report->cableFailure || $report->gpsMeasurement || $report->lance)
            <div class="page-break"></div>
            <h2>Uitgevoerde Werkzaamheden</h2>

            @if($report->radioDetection)
                <div class="mb-28">
                    <h4>Radiodetectie</h4>
                    <div class="panel">{{ \App\Models\RadioDetection::description() }}</div>

                    @if($report->radioDetection->sonde_type)
                        <h4 style="margin-left: 10px">Signaal met sonde</h4>
                        <table style="width: 100%; margin-bottom: 20px;">
                            <tr>
                                <td class="col-half" style="padding-right: 20px;">
                                    <div class="panel" style="margin-bottom: 0;">{{ \App\Models\RadioDetection::signalDescriptionFor(\App\Enums\MethodType::SignalSonde->value) }}</div>
                                </td>
                                <td class="col-half" style="padding-left: 20px;">
                                    <table class="kv-table">
                                        <tr><th>Sonde type</th><td>{{ $report->radioDetection->sonde_type }}</td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    @endif

                    @if($report->radioDetection->geleider_frequentie)
                        <h4 style="margin-left: 10px">Signaal met geleider</h4>
                        <table style="width: 100%; margin-bottom: 20px;">
                            <tr>
                                <td class="col-half" style="padding-right: 20px;">
                                    <div class="panel" style="margin-bottom: 0;">{{ \App\Models\RadioDetection::signalDescriptionFor(\App\Enums\MethodType::SignalGeleider->value) }}</div>
                                </td>
                                <td class="col-half" style="padding-left: 20px;">
                                    <table class="kv-table">
                                        <tr><th>Geleider frequentie</th><td>{{ $report->radioDetection->geleider_frequentie }} Hz</td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    @endif

                    <table class="kv-table">
                        <tr><th>Signaal op kabel</th><td>{{ $report->radioDetection->signaal_op_kabel }}</td></tr>
                        <tr><th>Signaal sterkte</th><td>{{ $report->radioDetection->signaal_sterkte }}</td></tr>
                        <tr><th>Frequentie</th><td>{{ $report->radioDetection->frequentie }}</td></tr>
                        <tr><th>Aansluiting</th><td>{{ $report->radioDetection->aansluiting }}</td></tr>
                        <tr><th>Zender type</th><td>{{ $report->radioDetection->zender_type }}</td></tr>
                    </table>


                </div>
            @endif

            @if($report->groundRadar)
                <div class="mb-28">
                    <h3>Grondradar</h3>
                    <div class="panel">{{ \App\Models\GroundRadar::description() }}</div>
                    <table class="kv-table">
                        <tr><th>Radarbeeld</th><td>{{ $report->groundRadar->radarbeeld }}</td></tr>
                        <tr><th>Detectiediepte</th><td>{{ $report->groundRadar->ingestelde_detectiediepte }}</td></tr>
                    </table>
                </div>
            @endif

            @if($report->gyroscope)
                <div class="mb-28">
                    <h3>Gyroscoopmeting</h3>
                    <div class="panel">{{ \App\Models\Gyroscope::description() }}</div>
                    <table class="kv-table">
                        <tr><th>Type boring</th><td>{{ $report->gyroscope->type_boring }}</td></tr>
                        <tr><th>Intredepunt</th><td>{{ $report->gyroscope->intredepunt }}</td></tr>
                        <tr><th>Uittredepunt</th><td>{{ $report->gyroscope->uittredepunt }}</td></tr>
                        <tr><th>Lengte tracé</th><td>{{ $report->gyroscope->lengte_trace }} m</td></tr>
                        <tr><th>Bodemprofiel GPS</th><td>{{ $report->gyroscope->bodemprofiel_ingemeten_met_gps ? 'Ja' : 'Nee' }}</td></tr>
                         <tr><th>Diameter buis</th><td>{{ $report->gyroscope->diameter_buis }} mm</td></tr>
                        <tr><th>Materiaal</th><td>{{ $report->gyroscope->materiaal }}</td></tr>
                         <tr><th>Ingemeten met</th><td>{{ $report->gyroscope->ingemeten_met }}</td></tr>
                        @if($report->gyroscope->bijzonderheden)
                            <tr><th>Bijzonderheden</th><td>{{ $report->gyroscope->bijzonderheden }}</td></tr>
                        @endif
                    </table>
                </div>
            @endif

            @if($report->testTrench)
                <div class="mb-28">
                    <h3>Proefsleuf</h3>
                    <div class="panel">{{ \App\Models\TestTrench::description() }}</div>
                    <table class="kv-table">
                        <tr><th>Gemaakt</th><td>{{ $report->testTrench->proefsleuf_gemaakt ? 'Ja' : 'Nee' }}</td></tr>
                        <tr><th>Manier van graven</th><td>{{ $report->testTrench->manier_van_graven }}</td></tr>
                        <tr><th>Type grondslag</th><td>{{ $report->testTrench->type_grondslag }}</td></tr>
                        <tr><th>KLIC melding</th><td>{{ $report->testTrench->klic_melding_gedaan ? 'Ja' : 'Nee' }} ({{ $report->testTrench->klic_nummer }})</td></tr>
                        <tr><th>Locatie</th><td>{{ $report->testTrench->locatie }}</td></tr>
                        <tr><th>Doel</th><td>{{ $report->testTrench->doel }}</td></tr>
                        <tr><th>Bevindingen</th><td>{{ $report->testTrench->bevindingen }}</td></tr>
                    </table>
                </div>
            @endif

            @if($report->cableFailure)
                <div class="mb-28">
                    <h3>Kabelstoring</h3>
                    <div class="panel">{{ \App\Models\CableFailure::description() }}</div>
                    @php($methodeDescription = \App\Models\CableFailure::methodDescriptionFor($report->cableFailure->methode_vaststelling ?? null))
                    @if($methodeDescription)
                        <div class="panel">{{ $methodeDescription }}</div>
                    @endif
                    <table class="kv-table">
                        <tr><th>Type storing</th><td>{{ $report->cableFailure->type_storing }}</td></tr>
                        <tr><th>Locatie</th><td>{{ $report->cableFailure->locatie_storing }}</td></tr>
                        <tr><th>Kabel met aftakking</th><td>{{ $report->cableFailure->kabel_met_aftakking ? 'Ja' : 'Nee' }}</td></tr>
                        <tr><th>Methode</th><td>{{ $report->cableFailure->methode_vaststelling }}</td></tr>
                        @if($report->cableFailure->bijzonderheden)
                            <tr><th>Bijzonderheden</th><td>{{ $report->cableFailure->bijzonderheden }}</td></tr>
                        @endif
                         @if($report->cableFailure->advies)
                            <tr><th>Advies</th><td>{{ $report->cableFailure->advies }}</td></tr>
                        @endif
                    </table>
                </div>
            @endif

            @if($report->gpsMeasurement)
                <div class="mb-28">
                    <h3>GPS-meting</h3>
                    <div class="panel">{{ \App\Models\GPSMeasurement::description() }}</div>
                     <table class="kv-table">
                        <tr><th>Gemeten met</th><td>{{ $report->gpsMeasurement->gemeten_met }}</td></tr>
                        <tr><th>Data naar tekenaar</th><td>{{ $report->gpsMeasurement->data_verstuurd_naar_tekenaar ? 'Ja' : 'Nee' }}</td></tr>
                        <tr><th>Signaal</th><td>{{ $report->gpsMeasurement->signaal }}</td></tr>
                        <tr><th>Omgeving</th><td>{{ $report->gpsMeasurement->omgeving }}</td></tr>
                    </table>
                </div>
            @endif

            @if($report->lance)
                 <div class="mb-28">
                    <h3>Aanlansen / Aanprikken</h3>
                    <div class="panel">{{ \App\Models\Lance::description() }}</div>
                     <table class="kv-table">
                         <tr><th>Aanprikdiepte</th><td>{{ $report->lance->aanprikdiepte !== null ? number_format($report->lance->aanprikdiepte, 2, ',', '.') : '-' }} m</td></tr>
                    </table>
                </div>
            @endif

        @endif

        {{-- Findings & Advice --}}
        @if($report->results_summary || $report->advice || $report->follow_up)
            <div class="page-break"></div>
            <h2>Bevindingen &amp; Advies</h2>

            @if($report->results_summary)
                <h3>Samenvatting resultaten</h3>
                <div class="panel">{{ $report->results_summary }}</div>
            @endif

            @if($report->advice)
                <h3>Advies / Aanbevelingen</h3>
                <div class="panel">{{ $report->advice }}</div>
            @endif

            @if($report->follow_up)
                <h3>Vervolgacties</h3>
                <div class="panel">{{ $report->follow_up }}</div>
            @endif
        @endif

        {{-- Images --}}
        @if($report->images->count())
            <div class="page-break"></div>
            <h2>Afbeeldingen</h2>

            <div class="image-gallery">
                @foreach($report->images as $image)
                    <?php $path = public_path('storage/images/reports/'.$report->id.'/'.$image->path); ?>
                    @if(file_exists($path))
                        <div class="gallery-item">
                            <img src="{{ $path }}" alt="Report Image" class="report-image">
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

    </div>
</body>
</html>
