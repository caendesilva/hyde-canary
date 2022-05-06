{{-- The core HydeFront stylesheet --}}
<link rel="stylesheet" href="{{ Hyde::relativeLink('media/hyde.css', $currentPage) }}">

{{-- The compiled Tailwind/App styles --}}
@if(Hyde::assetManager()->hasMediaFile('app.css'))
<link rel="stylesheet" href="{{ Hyde::relativeLink('media/app.css', $currentPage) }}">
@endif

{{-- Add any extra styles to include after the others --}}
@stack('styles')