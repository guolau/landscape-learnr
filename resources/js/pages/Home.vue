<template>
    <div class="grid grid-cols-5 gap-5 mx-auto max-w-4xl">
        <select
            v-if="tagCategory"
            name="tag_id"
            v-model="tag_id"
            class="col-span-2"
        >
            <option value="">
                Select {{ tagCategory.name.toLowerCase() }}
            </option>
            <option v-for="tag in tags" value="tag.id">{{ tag.name }}</option>
        </select>
        <input
            name="search"
            type="text"
            :class="tagCategory ? 'col-span-3' : 'col-span-5'"
            placeholder="Search"
        />
    </div>

    <h1 class="text-center my-8">Results for ...</h1>

    <div class="my-8">
        <!-- <Results></Results> -->
    </div>
</template>

<script setup>
import Results from "../components/Results.vue";
import Select from "@components/form/Select.vue";
import { ref } from "vue";

defineProps({
    name: String,
    tags: Array,
    tagCategory: Object,
});

let tag_id = ref("");
</script>
