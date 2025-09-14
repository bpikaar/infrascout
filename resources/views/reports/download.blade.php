<h2>Cable type</h2>
<p>{{ $report->cable_type }}</p>
<p>{{ $report->images[0]->path }}</p>
@php
    $path = $report->images[0]->path;
@endphp
<img src="{{ asset('images/reports/'.$report->id.'/'.$path) }}" alt=""/>
