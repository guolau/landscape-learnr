<template>
    <section
        class="ll-panel grid xl:grid-cols-5 lg:grid-cols-2 md:grid-cols-9 grid-cols-1 gap-7"
    >
        <div class="xl:col-span-2 lg:col-span-1 md:col-span-5 col-span-1">
            <div v-if="mainImage" class="grid grid-cols-8 gap-2">
                <div
                    class="flex flex-col col-span-1 gap-0.5 overflow-auto"
                    v-if="snippet.images.length > 1"
                >
                    <img
                        v-for="(image, index) in snippet.images.filter(
                            (image) => image.thumbnail_path,
                        )"
                        :src="asset(`storage/${image.thumbnail_path}`)"
                        :alt="image.alt_text"
                        class="max-w-32 p-1"
                        :class="{
                            'border-solid border-[3px] border-neutral-800 p-px':
                                mainImage.id == image.id,
                        }"
                        @click="updateMainImage(image)"
                    />
                </div>
                <a
                    :href="asset(`storage/${mainImage.image_path}`)"
                    target="_blank"
                    class="col-span-7"
                >
                    <img
                        :src="asset(`storage/${mainImage.image_path}`)"
                        :alt="mainImage.alt_text"
                    />
                </a>
            </div>
        </div>
        <div class="xl:col-span-3 lg:col-span-1 md:col-span-4 col-span-1">
            <div class="flex flex-col gap-3">
                <h2 class="border-none mb-0">{{ snippet.title }}</h2>
                <div v-html="snippet.body_html"></div>
                <div class="flex gap-2 items-center">
                    Street View:
                    <a
                        v-for="link in snippet.street_view_links"
                        :href="link.url"
                        class="ll-btn-outline ll-btn-sm !rounded-full"
                        target="_blank"
                    >
                        {{ link.title }} <OpenNewWindow />
                    </a>
                </div>
                <div class="flex flex-wrap gap-2 items-center">
                    Tags:
                    <Link
                        v-for="tag in snippet.tags"
                        class="ll-btn-secondary ll-btn-sm rounded-full"
                        href="#"
                        >{{ tag.name }}
                    </Link>
                </div>
                <div class="flex gap-2 text-xs">
                    <span
                        :title="formatDate(snippet.created_at, dateFormatOpts)"
                    >
                        Created {{ formatRelativeDate(snippet.created_at) }}
                    </span>
                    <span>•</span>
                    <span
                        :title="formatDate(snippet.revised_at, dateFormatOpts)"
                    >
                        Revised {{ formatRelativeDate(snippet.revised_at) }}
                    </span>
                </div>
                <div class="text-ms flex gap-5">
                    <Link :href="$route('snippets.show', snippet.id)"
                        ><LinkIcon></LinkIcon> Permalink</Link
                    >
                    <Link :href="$route('snippets.edit', snippet.id)"
                        ><Edit class="mr-0.5"></Edit> Edit
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link as LinkIcon, OpenNewWindow, Edit } from "@iconoir/vue";
import { asset, formatRelativeDate, formatDate } from "@components/Utils.js";
import { ref } from "vue";

let props = defineProps({
    snippet: Object,
});

const dateFormatOpts = {
    dateStyle: "long",
    timeStyle: "short",
};

let mainImage = ref(null);

let updateMainImage = (image) => {
    mainImage.value = image ?? null;
};

updateMainImage(props.snippet.images[0]);
</script>
