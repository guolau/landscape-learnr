<template>
    <nav v-if="links.length > 3" class="flex gap-2 mt-5 justify-center">
        <Component
            v-for="(link, index) in links"
            :is="link.url ? 'Link' : 'span'"
            :href="link.url"
            class="px-3 py-1"
            :class="{
                'text-neutral-500': !link.url,
                '!no-underline !rounded-md bg-teal-800 text-neutral-100':
                    link.active,
                '!no-underline !rounded-md hover:bg-neutral-200':
                    !link.active && link.url,
                '!px-2': index == 0 || index == links.length - 1,
            }"
        >
            <div v-if="index == 0">
                <NavArrowLeft stroke-width="2.5"></NavArrowLeft>
            </div>
            <div v-else-if="index == links.length - 1">
                <NavArrowRight stroke-width="2.5"></NavArrowRight>
            </div>
            <div v-else>{{ link.label }}</div>
        </Component>
    </nav>
</template>

<script setup>
import { NavArrowLeft, NavArrowRight } from "@iconoir/vue";

const props = defineProps({
    links: Array,
});
</script>
