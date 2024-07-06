<template>
    <Head> </Head>

    <IconoirProvider
        :icon-props="{
            'stroke-width': 1.7,
            width: '1.05em',
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
                    LandscapeLearnr
                </Link>

                <ul class="h-full">
                    <li
                        class="ll-dropdown h-full"
                        aria-haspopup="true"
                        v-if="user && user.is_admin"
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

                <ul class="h-full ml-auto mr-0">
                    <li
                        class="ll-dropdown ll-dropdown-align-right h-full"
                        aria-haspopup="true"
                        v-if="user && user.is_admin"
                    >
                        <button class="ll-dropdown-btn h-full">
                            {{ user.username }} <NavArrowDown />
                        </button>

                        <ul class="ll-dropdown-content" aria-label="submenu">
                            <li>
                                <Link :href="$route('logout')" method="post">
                                    Log out
                                </Link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>

        <FlashMessage
            :message="flash.message || ''"
            :status="flash.status"
        ></FlashMessage>

        <slot />

        <footer class="my-8">
            <div class="flex items-center gap-4 justify-center">
                <div>
                    Made with
                    <HeartSolid class="text-rose-800"></HeartSolid> by Laura
                </div>
                <div>
                    <a href="https://github.com/guolau/landscape-learnr"
                        >View on GitHub</a
                    >
                </div>
            </div>
        </footer>
    </IconoirProvider>
</template>

<script setup>
import { IconoirProvider, HeartSolid, NavArrowDown } from "@iconoir/vue";
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import FlashMessage from "@components/FlashMessage.vue";

const page = usePage();

const user = computed(() => page.props.auth.user);

const flash = computed(() => page.props.flash);
</script>
