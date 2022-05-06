{{-- The core HydeFront scripts --}}
<script defer src="{{ Hyde::relativeLink('media/hyde.js', $currentPage) }}"></script>

{{-- The compiled Laravel Mix scripts --}}
@if(Hyde::assetManager()->hasMediaFile('app.js'))
<script defer src="{{ Hyde::relativeLink('media/app.js', $currentPage) }}"></script>
@endif

{{-- Include any extra scripts to include before the closing <body> tag --}}
@stack('scripts')