<template>
    <main class="ll-panel mx-auto max-w-5xl">
        <div class="flex justify-between items-start">
            <h1>Settings</h1>
        </div>

        <form @submit.prevent="submit" @enctype="multipart / form - data">
            <section>
                <Select
                    name="search_page_dropdown_tag_category_id"
                    label="Tag category shown in search page dropdown"
                    emptyOptionLabel="No category selected"
                    :options="tagCategories"
                    v-model="form.search_page_dropdown_tag_category_id"
                >
                    <template v-slot:hint>
                        This determines which tags show in the dropdown filter
                        on the
                        <a :href="$route('home')" target="_blank"
                            >main search page</a
                        >. If no category is selected, then the dropdown is
                        hidden.
                    </template>
                </Select>
            </section>

            <button
                class="ll-btn-primary"
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Save Settings
            </button>
        </form>
    </main>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Select from "@components/form/Select.vue";

const props = defineProps({
    tagCategories: Array,
    settings: Object,
});

let form = useForm({
    search_page_dropdown_tag_category_id:
        props.settings.search_page_dropdown_tag_category_id || "",
});

let submit = () => {
    form.post(route("settings.update"));
};
</script>
