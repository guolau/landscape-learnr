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
        <header>
            <nav
                class="mb-6 h-16 flex items-center border-dashed border-b border-neutral-300"
            >
                <Link
                    :href="$route('home')"
                    class="mr-5 text-xl text-neutral-800 !no-underline ml-5"
                >
                    Learn Landscapes
                </Link>

                <ul class="h-full">
                    <li
                        class="ll-dropdown ll-dropdown-align-right h-full"
                        aria-haspopup="true"
                    >
                        <button class="ll-dropdown-btn h-full">
                            Admin <NavArrowDown />
                        </button>

                        <ul class="ll-dropdown-content" aria-label="submenu">
                            <li>
                                <Link :href="$route('snippets.index')"
                                    >Snippets</Link
                                >
                            </li>
                            <li><Link href="#">Tag Manager</Link></li>
                        </ul>
                    </li>
                </ul>
            </nav>
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
import { IconoirProvider, HeartSolid, NavArrowDown } from "@iconoir/vue";
</script>
