<template>
    <Head>
        <title>Learn Landscapes</title>
    </Head>

    <IconoirProvider
        :icon-props="{
            'stroke-width': 1.7,
            width: '1em',
            height: '1.05em',
            class: 'iconoir-svg',
        }"
    >
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
                <div>
                    Made with
                    <HeartSolid class="text-rose-800"></HeartSolid> by Laura
                </div>
                <div>
                    <a href="https://github.com/guolau/learn-landscapes"
                        >View on GitHub</a
                    >
                </div>
            </div>
        </footer>
    </IconoirProvider>
</template>

<script setup>
import { IconoirProvider, HeartSolid } from "@iconoir/vue";
</script>
