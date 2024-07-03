<template>
    <main class="ll-panel mx-auto max-w-7xl">
        <div class="flex justify-between items-start">
            <h1>Snippets</h1>
            <Link
                :href="$route('snippets.create')"
                class="ll-btn ll-btn-primary ll-btn-sm"
            >
                <Plus class="mr-1"></Plus>New Snippet
            </Link>
        </div>

        <section
            v-if="snippets.data.length == 0"
            class="text-center my-8 ll-text-muted italic"
        >
            No snippets found.
        </section>

        <section
            v-for="snippet in snippets.data"
            class="grid sm:grid-cols-16 grid-cols-1 lg:gap-6 md:gap-4 sm:gap-4 gap-6 border-t border-neutral-200 py-5"
        >
            <!-- Main Image -->
            <div class="md:col-span-4 sm:col-span-3 w-full">
                <img
                    v-if="snippet.images[0]"
                    :src="asset(`storage/${snippet.images[0].thumbnail_path}`)"
                    class="w-full h-auto"
                />
            </div>

            <!-- Content -->
            <div class="sm:col-span-9 flex flex-col gap-2">
                <h2 class="font-bold mb-0 text-base">{{ snippet.title }}</h2>
                <div
                    v-html="snippet.body_html"
                    class="max-h-[4.5rem] overflow-hidden"
                ></div>

                <!-- Tags -->
                <div class="flex gap-2 content-start flex-wrap">
                    <Link
                        v-for="tag in snippet.tags"
                        class="ll-btn-secondary py-1 p-3 rounded-full text-xs"
                        href="#"
                        >{{ tag.name }}
                    </Link>
                </div>

                <!-- Actions -->
                <div class="flex gap-5 text-sm">
                    <Link :href="$route('snippets.show', snippet.id)"
                        ><LinkIcon class="mr-0.5"></LinkIcon> Permalink
                    </Link>
                    <Link :href="$route('snippets.edit', snippet.id)"
                        ><Edit class="mr-0.5"></Edit> Edit
                    </Link>
                </div>
            </div>

            <!-- Timestamps -->
            <div
                class="md:col-span-3 sm:col-span-4 lg:text-sm md:text-xs sm:text-xs text-sm flex flex-col justify-center gap-1"
            >
                <div :title="`Database ID ${snippet.id}`" class="flex">
                    <span><Database class="mr-3"></Database></span>
                    <span>{{ snippet.id }}</span>
                </div>
                <div
                    :title="formatDate(snippet.revised_at, dateFormatOpts)"
                    class="flex"
                >
                    <span><EditPencil class="mr-3"></EditPencil></span>
                    <span
                        >Revised
                        {{ formatRelativeDate(snippet.revised_at) }}
                    </span>
                </div>
                <div
                    :title="formatDate(snippet.updated_at, dateFormatOpts)"
                    class="flex"
                >
                    <span><Refresh class="mr-3"></Refresh></span>
                    <span
                        >Updated
                        {{ formatRelativeDate(snippet.updated_at) }}
                    </span>
                </div>
                <div
                    :title="formatDate(snippet.created_at, dateFormatOpts)"
                    class="flex"
                >
                    <span><PlusCircle class="mr-3"></PlusCircle></span>
                    <span>
                        Created
                        {{ formatRelativeDate(snippet.created_at) }}
                    </span>
                </div>
            </div>
        </section>

        <Pagination :links="snippets.links"></Pagination>
    </main>
</template>

<script setup>
import {
    asset,
    formatRelativeDate,
    formatDate,
} from "@components/form/Utils.js";
import {
    EditPencil,
    Edit,
    Refresh,
    PlusCircle,
    Link as LinkIcon,
    Database,
    Plus,
} from "@iconoir/vue";
import Pagination from "@components/Pagination.vue";

const props = defineProps({
    snippets: Object,
});

const dateFormatOpts = {
    dateStyle: "long",
    timeStyle: "short",
};
</script>
