{{-- The core HydeFront stylesheet --}}
<link rel="stylesheet" href="{{ Hyde::relativeLink('media/hyde.css', $currentPage) }}">

{{-- The compiled Tailwind/App styles --}}
@if(Hyde::assetManager()->hasMediaFile('app.css'))
<link rel="stylesheet" href="{{ Hyde::relativeLink('media/app.css', $currentPage) }}">
@endif

{{-- Add any extra styles to include after the others --}}
@stack('styles')
{{-- 

<style>
	blockquote.info {
		border-color: DodgerBlue;
	}

	blockquote.warning {
		border-color: orange;
	}

	blockquote.danger {
		border-color: red;
	}

	blockquote.success {
		border-color: MediumSeaGreen;
	}
</style>
<style>
	:not(code)>.filepath {
		display: none;
	}

	pre>code>.filepath {
		position: relative;
		top: -.25rem;
		right: 0.25rem;
		float: right;
		opacity: .5;
		transition: opacity 0.25s;
	}

	.torchlight-enabled pre>code>.filepath {
		right: 1rem;
	}

	pre>code>.filepath:hover {
		opacity: 1;
	}
</style> --}}