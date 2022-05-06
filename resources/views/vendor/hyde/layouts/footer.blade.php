<footer aria-label="Page footer" class="flex py-4 px-6 w-full text-center mt-auto bg-slate-100 dark:bg-gray-800">
	<div class="text-center mx-auto">
		<a href="https://github.com/caendesilva/hyde-canary" class="underline">Hyde Canary</a> {{ (trim(shell_exec('git describe --tags --abbrev=0 || echo dev-master'))) }}-<a href="https://github.com/caendesilva/hyde-canary/commit/{{ shell_exec('git rev-parse HEAD') }}" class="underline">{{ shell_exec('git rev-parse --short HEAD') }}</a>
	</div>
	<a href="#app" aria-label="Go to top of page" class="float-right">
		<button title="Scroll to top">
			<svg role="presentation" class="fill-current text-gray-500 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
				<path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/>
			</svg>
		</button>
	</a>
</footer>
