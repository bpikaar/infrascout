<?php use Illuminate\Support\Facades\Storage; ?>
@props(['report', 'methodType'])

<?php $methodImages = $report->images->where('method', $methodType); ?>
@if($methodImages->count())
    <div class="image-gallery">
        @foreach($methodImages as $image)
            <?php $path = Storage::disk('local')->path('images/reports/' . $report->id . '/' . $image->path); ?>
            @if(file_exists($path))
                <div class="gallery-item">
                    <img src="{{ $path }}" alt="Report Image" class="report-image">
                </div>
            @endif
        @endforeach
    </div>
@endif
