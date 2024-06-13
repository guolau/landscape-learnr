<template>
    <form
        @submit.prevent="submit"
        v-on:keydown.enter.prevent=""
        enctype="multipart/form-data"
    >
        <section>
            <h2>Title and Body</h2>

            <Text name="name" v-model="form.name" />
            <TextArea
                name="body_html"
                label="Body"
                :is_html_editor="true"
                v-model="form.body_html"
            />
        </section>

        <section>
            <h2>Image</h2>

            <div class="ll-form-row-grid">
                <File
                    name="image"
                    wrapperClasses="col-span-6"
                    v-model="form.image"
                />

                <div class="col-span-6">
                    <TextArea
                        name="alt_text"
                        :rows="3"
                        v-model="form.alt_text"
                    />
                    <TextArea
                        name="attribution"
                        :rows="2"
                        v-model="form.attribution"
                    />
                    <Text
                        name="source_url"
                        label="Source URL"
                        v-model="form.source_url"
                    />
                </div>
            </div>

            <div class="ll-form-row-grid">
                <Text
                    name="license"
                    wrapperClasses="col-span-4"
                    v-model="form.license"
                />
                <Text
                    name="license_url"
                    label="License URL"
                    wrapperClasses="col-span-8"
                    v-model="form.license_url"
                />
            </div>
        </section>

        <section>
            <h2>Street View Links</h2>

            <div
                v-for="(link, index) in form.street_view_links"
                class="ll-form-row-grid"
            >
                <Text
                    name="title"
                    label="Title"
                    wrapperClasses="col-span-4 !mb-0"
                    v-model="form.street_view_links[index].title"
                    @input="onStreetViewLinkInput"
                    :showLabel="!index"
                />
                <Text
                    name="street_view_links"
                    label="URL"
                    wrapperClasses="col-span-8 !mb-0"
                    v-model="form.street_view_links[index].url"
                    @input="onStreetViewLinkInput"
                    :showLabel="!index"
                />
            </div>
        </section>

        <section>
            <h2>Tags</h2>

            <Text
                name="tags"
                label="Search Tag"
                wrapperClasses="max-w-sm"
                inputClasses="!rounded-r-none"
                v-model="tagInput"
                @keyup.enter="onAddTag"
            >
                <template v-slot:after>
                    <button
                        type="button"
                        class="ll-btn-secondary rounded-l-none"
                        @click="onAddTag"
                    >
                        <Plus />
                    </button>
                </template>
            </Text>

            <div class="flex flex-wrap mt-3 gap-3">
                <div
                    v-for="tag in form.tags"
                    class="py-2 pl-5 pr-2 bg-gray-200 rounded-full"
                >
                    {{ tag }}
                    <button
                        type="button"
                        class="ll-btn-secondary rounded-full py-0 px-1 ml-1"
                        @click="onRemoveTag(tag)"
                    >
                        <Xmark />
                    </button>
                </div>
            </div>
        </section>

        <button class="ll-btn-primary" type="submit">Create Snippet</button>
    </form>
</template>

<script setup>
import { ref } from "vue";
import Text from "@components/form/Text.vue";
import TextArea from "@components/form/TextArea.vue";
import File from "@components/form/File.vue";
import { router } from "@inertiajs/vue3";
import { reactive } from "vue";
import { isObjectEmpty } from "@components/form/Utils.js";
import throttle from "lodash/debounce";
import { Plus, Xmark } from "@iconoir/vue";

let form = reactive({
    body_html: "",
    images: [],
    street_view_links: [],
    tags: [],
    is_revised: false,
});

let submit = () => {
    router.post(route("snippets.store"), form);
};

// Street View Links logic
let updateStreetViewLinkInputs = () => {
    let inputs = form.street_view_links;
    let last = inputs[inputs.length - 1];
    let nextToLast = inputs[inputs.length - 2];

    if (inputs.length > 1 && isObjectEmpty(last) && isObjectEmpty(nextToLast)) {
        inputs.pop();
    } else if (!last || !isObjectEmpty(last)) {
        inputs.push({
            title: "",
            url: "",
        });
    }
};

let onStreetViewLinkInput = throttle(
    function () {
        updateStreetViewLinkInputs();
    },
    250,
    { leading: true, trailing: true },
);

updateStreetViewLinkInputs();

// Tags logic
let tagInput = ref();

let onAddTag = () => {
    if (tagInput.value && !form.tags.includes(tagInput.value)) {
        form.tags.push(tagInput.value);
    }
    tagInput.value = null;
};

let onRemoveTag = (tag) => {
    let index = form.tags.indexOf(tag);
    if (index >= 0) {
        form.tags.splice(index, 1);
    }
};
</script>
