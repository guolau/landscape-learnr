<template>
    <section
        class="ll-panel grid xl:grid-cols-5 lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-7"
    >
        <div class="xl:col-span-2 col-span-1">
            <div>
                <img
                    :src="asset(`storage/${mainImage.image_path}`)"
                    :alt="snippet.images[0].alt_text"
                />
            </div>
            <div class="flex gap-0.5 mt-2">
                <img
                    v-for="(image, index) in snippet.images"
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
        </div>
        <div class="xl:col-span-3 col-span-1">
            <div class="flex flex-col gap-2">
                <h2 class="border-none mb-0">{{ snippet.title }}</h2>
                <div v-html="snippet.body_html"></div>
                <div class="flex gap-2 items-center">
                    Street View:
                    <a
                        v-for="link in snippet.street_view_links"
                        :href="link.url"
                        class="ll-btn-primary py-1 p-3 text-sm !rounded-full"
                        target="_blank"
                    >
                        <Link /> {{ link.title }}
                    </a>
                </div>
                <div class="flex gap-2 items-center">
                    Tags:
                    <a
                        v-for="tag in snippet.tags"
                        class="ll-btn-secondary py-1 p-3 bg-neutral-200 rounded-full text-sm"
                        href="#"
                        >{{ tag.name }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from "@iconoir/vue";
import { asset } from "@components/form/Utils.js";
import { ref } from "vue";

let props = defineProps({
    snippet: Object,
});

let mainImage = ref(null);

let updateMainImage = (image) => {
    mainImage.value = image;
};

updateMainImage(props.snippet.images[0]);
</script>
