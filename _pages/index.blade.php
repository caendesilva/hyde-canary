@extends('hyde::layouts.app')
@section('content')
 @push('styles')
 <style>
    /* Gradients by https://uigradients.com/ */
    #app {
        /* Royal */
        background: #141E30; /* fallback for old browsers */
        background: -webkit-linear-gradient(to left bottom, #243B55, #141E30); /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to left bottom, #243B55, #141E30); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }
    .logo-gradient {
        /* Flare */
        background-image: linear-gradient(to bottom right, #f12711, #f5af19);
        padding-top: .5rem;
        padding-bottom: 1rem;
    }
    .theme-toggle-button {
        display: none;
    }
</style>
 @endpush
    <main class="my-auto px-6 pb-12 antialiased app-gradient-dark">
        <div class="mx-auto max-w-7xl">
            <!-- Main Hero Content -->
            <div class="container max-w-lg px-4 py-32 mx-auto text-left md:max-w-none md:text-center">
                <h1 class="text-5xl font-extrabold leading-10 tracking-tight text-left text-gray-100 md:text-center sm:leading-none md:text-6xl lg:text-7xl">
                    <span class="block text-4xl md:text-5xl mb-4 sm:mb-0">You're running on </span><span
                        class="relative mt-2 text-transparent bg-clip-text bg-gradient-to-br logo-gradient md:inline-block drop-shadow-2xl tracking-normal">HydePHP</span>
                    <small><i>CANARY</i></small>
                </h1>
                <div class="mx-auto mt-8 sm:mt-4 text-gray-200 md:mt-8 md:max-w-2xl md:text-center">
                    <section aria-label="About Hyde">
                        <p class="lg:text-lg">
                            Leap into the future of static HTML blogs and documentation with the tools you already know and love.
                            Made with Tailwind, Laravel, and Coffee.
                        </p>
                    </section>
                </div>
            </div>
            <!-- End Main Hero Content -->
        </div>
    </main>

@endsection
