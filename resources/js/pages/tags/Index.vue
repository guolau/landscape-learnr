<template>
    <main class="ll-panel mx-auto max-w-5xl">
        <div class="flex justify-between items-start">
            <h1>Tags</h1>
            <select v-model="category_id" class="ll-input-sm">
                <option value="">Filter category</option>
                <option v-for="category in categories" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
        </div>
        <section
            v-if="tags.data.length == 0"
            class="text-center my-8 ll-text-muted italic"
        >
            No tags found.
        </section>
        <section
            v-for="tag in tags.data"
            class="grid grid-cols-12 gap-6 border-t border-neutral-200 py-5"
        >
            <div class="col-span-3">
                <div>{{ tag.name }}</div>
                <div
                    v-if="tag.tag_category"
                    class="text-sm ll-text-muted italic"
                >
                    {{ tag.tag_category.name }}
                </div>
            </div>
            <div class="col-span-6">
                <span v-if="tag.description">
                    {{ tag.description }}
                </span>
                <span v-else class="ll-text-muted italic">
                    No description found.
                </span>
            </div>
            <div
                class="col-span-3 lg:text-sm md:text-xs sm:text-xs text-sm flex flex-col justify-center gap-1"
            >
                <div :title="`Database ID ${tag.id}`" class="flex">
                    <span><Database class="mr-3"></Database></span>
                    <span>{{ tag.id }}</span>
                </div>
                <div
                    :title="formatDate(tag.updated_at, dateFormatOpts)"
                    class="flex"
                >
                    <span><Refresh class="mr-3"></Refresh></span>
                    <span
                        >Updated
                        {{ formatRelativeDate(tag.updated_at) }}
                    </span>
                </div>
                <div
                    :title="formatDate(tag.created_at, dateFormatOpts)"
                    class="flex"
                >
                    <span><EditPencil class="mr-3"></EditPencil></span>
                    <span
                        >Created
                        {{ formatRelativeDate(tag.created_at) }}
                    </span>
                </div>
            </div>
        </section>

        <Pagination :links="tags.links"></Pagination>
    </main>
</template>

<script setup>
import { formatRelativeDate, formatDate } from "@components/Utils.js";
import { EditPencil, Refresh, Database } from "@iconoir/vue";
import Pagination from "@components/Pagination.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    tags: Object,
    categories: Object,
    filters: Object,
});

const dateFormatOpts = {
    dateStyle: "long",
    timeStyle: "short",
};

let category_id = ref(
    props.filters.category_id == undefined ? "" : props.filters.category_id,
);

watch(category_id, (value) => {
    router.visit(route("tags.index"), {
        preserveState: true,
        data: { category_id: category_id.value },
    });
});
</script>
