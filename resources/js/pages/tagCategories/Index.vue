<template>
    <main class="ll-panel mx-auto max-w-5xl">
        <div class="flex justify-between items-start">
            <h1>Tag Categories</h1>
        </div>
        <section
            v-if="categories.data.length == 0"
            class="text-center my-8 ll-text-muted italic"
        >
            No categories found.
        </section>
        <section
            v-for="category in categories.data"
            class="grid grid-cols-12 gap-6 border-t border-neutral-200 py-5"
        >
            <div class="col-span-3">
                <div>{{ category.name }}</div>
            </div>
            <div class="col-span-6 flex flex-col gap-2">
                <div v-if="category.description">
                    {{ category.description }}
                </div>
                <div v-else class="ll-text-muted italic">
                    No description found.
                </div>
                <div class="flex gap-2 content-start flex-wrap">
                    <Link
                        v-for="tag in category.tags"
                        class="ll-btn-secondary py-1 p-3 rounded-full text-xs"
                        :href="$route('home', { keyword: tag.name })"
                        >{{ tag.name }}
                    </Link>
                    <Link
                        v-if="category.tags_count > category.tags.length"
                        class="text-sm"
                        :href="
                            $route('tags.index', { category_id: category.id })
                        "
                        >View all {{ category.tags_count }} tags</Link
                    >
                </div>
            </div>
            <div
                class="col-span-3 lg:text-sm md:text-xs sm:text-xs text-sm flex flex-col justify-center gap-1"
            >
                <div :title="`Database ID ${category.id}`" class="flex">
                    <span><Database class="mr-3"></Database></span>
                    <span>{{ category.id }}</span>
                </div>
                <div
                    :title="formatDate(category.updated_at, dateFormatOpts)"
                    class="flex"
                >
                    <span><Refresh class="mr-3"></Refresh></span>
                    <span
                        >Updated
                        {{ formatRelativeDate(category.updated_at) }}
                    </span>
                </div>
                <div
                    :title="formatDate(category.created_at, dateFormatOpts)"
                    class="flex"
                >
                    <span><EditPencil class="mr-3"></EditPencil></span>
                    <span
                        >Created
                        {{ formatRelativeDate(category.created_at) }}
                    </span>
                </div>
            </div>
        </section>

        <Pagination :links="categories.links"></Pagination>
    </main>
</template>

<script setup>
import { formatRelativeDate, formatDate } from "@components/Utils.js";
import { EditPencil, Refresh, Database } from "@iconoir/vue";
import Pagination from "@components/Pagination.vue";

const props = defineProps({
    categories: Object,
});

const dateFormatOpts = {
    dateStyle: "long",
    timeStyle: "short",
};
</script>
