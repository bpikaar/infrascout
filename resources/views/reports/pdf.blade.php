<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapport {{ $report->project->name }}</title>
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
                <h1>Report #{{ $report->id }}</h1>
                <p>Project: {{ $report->project->name ?? 'N/A' }}</p>
                <p>Work Date: {{ $report->date_of_work->format('Y-m-d') }}</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Report Details</div>
            <div class="grid">
                <div class="grid-col">
                    <strong>Project</strong><br>
                    {{ $report->project->name ?? 'N/A' }}<br>
                    <span style="color: #555; font-size: 0.95em;">Project #{{ $report->project->number ?? 'N/A' }}</span>
                </div>
                <div class="grid-col">
                    <strong>Date of Work</strong><br>
                    {{ $report->date_of_work->format('l, F j, Y') }}<br>
                    <span style="color: #555; font-size: 0.95em;">{{ $report->date_of_work->format('H:i') }}</span>
                </div>
                <div class="grid-col">
                    <strong>Created By</strong><br>
                    {{ $report->user->name ?? 'N/A' }}<br>
                    <span style="color: #555; font-size: 0.95em;">{{ $report->user->email ?? 'N/A' }}</span>
                </div>
                <div class="grid-col">
                    <strong>Field Worker</strong><br>
                    {{ $report->fieldWorker->name ?? 'N/A' }}<br>
                    <span style="color: #555; font-size: 0.95em;">{{ $report->fieldWorker->email ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Technical Specifications</div>
            <div class="grid">
                <div class="grid-col">
                    <strong>Cable Type</strong><br>
                    {{ $report->cable_type }}
                </div>
                <div class="grid-col">
                    <strong>Material</strong><br>
                    {{ $report->material }}
                </div>
                <div class="grid-col">
                    <strong>Diameter</strong><br>
                    {{ $report->diameter }}mm
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Work Information</div>
            <div class="grid">
                <div class="grid-col">
                    <strong>Work Hours</strong><br>
                    {{ $report->work_hours }}
                </div>
                <div class="grid-col">
                    <strong>Travel Time</strong><br>
                    {{ $report->travel_time }}
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Description</div>
            <div class="description">
                {{ $report->description }}
            </div>
        </div>

        <div class="section">
            <div class="section-title">Images</div>
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
                <p style="color: #888;">No images for this report.</p>
            @endif
        </div>

        <div class="section">
            <div class="section-title">Timestamps</div>
            <div class="timestamps">
                <div class="grid-col">
                    <strong>Created At</strong><br>
                    {{ $report->created_at->format('Y-m-d H:i') }}
                </div>
                <div class="grid-col">
                    <strong>Last Updated</strong><br>
                    {{ $report->updated_at->format('Y-m-d H:i') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
