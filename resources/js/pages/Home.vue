<template>
    <main class="mx-auto max-w-7xl">
        <section class="grid grid-cols-5 gap-5 mx-auto max-w-4xl">
            <select
                v-if="tagCategory"
                name="tag_id"
                v-model="tag_id"
                class="col-span-2"
            >
                <option value="">
                    Select {{ tagCategory.name.toLowerCase() }}
                </option>
                <option v-for="tag in tags" :value="tag.id">
                    {{ tag.name }}
                </option>
            </select>
            <input
                name="keyword"
                type="text"
                v-model="keyword"
                :class="tagCategory ? 'col-span-3' : 'col-span-5'"
                placeholder="Search"
                @input="onSearch"
            />
        </section>

        <section
            v-if="snippets.data.length == 0"
            class="text-center my-8 text-lg ll-text-muted italic"
        >
            No results found.
        </section>

        <section>
            <Snippet
                v-for="snippet in snippets.data"
                :key="snippet.id"
                :snippet="snippet"
            ></Snippet>
        </section>

        <Pagination :links="snippets.links"></Pagination>
    </main>
</template>

<script setup>
import Snippet from "@components/Snippet.vue";
import Pagination from "@components/Pagination.vue";
import { ref, watch } from "vue";
import throttle from "lodash/debounce";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    name: String,
    tags: Array,
    tagCategory: Object,
    snippets: Object,
    filters: Object,
});

let tag_id = ref(props.filters.tag_id ?? "");
let keyword = ref(props.filters.keyword ?? "");

function getResults() {
    router.visit(route("home"), {
        method: "get",
        preserveState: true,
        data: { tag_id: tag_id.value, keyword: keyword.value },
    });
}

watch(tag_id, (value) => {
    getResults();
});

let onSearch = throttle(getResults, 250, { leading: true, trailing: true });
</script>
