<template>
    <Head>
        <title>Learn Landscapes</title>
    </Head>

    <header class="py-6 text-center">
        <Link
            :href="$route('home')"
            class="text-xl text-neutral-800 !no-underline"
        >
            Learn Landscapes
        </Link>
    </header>

    <slot />

    <footer class="my-8">
        <div class="flex items-center gap-4 justify-center">
            <div>Made with ♥ by Laura</div>
            <div>
                <a href="https://github.com/guolau/learn-landscapes"
                    >View on GitHub</a
                >
            </div>
        </div>
    </footer>
</template>
