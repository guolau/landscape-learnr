<template>
    <form
        @submit.prevent="submit"
        v-on:keydown.enter.prevent=""
        enctype="multipart/form-data"
    >
        <section>
            <h2>Title and Body</h2>

            <Text name="name" v-model="form.name" max-length="150" required />
            <TextArea
                name="body_html"
                label="Body"
                :is_html_editor="true"
                v-model="form.body_html"
            />
        </section>

        <section>
            <h2>Image</h2>

            <div
                v-for="(image, index) in form.images"
                class="pb-6 mb-6 border border-dashed border-transparent border-b-neutral-200 last:border-none"
                @input="onImageInput"
            >
                <div class="ll-form-row-grid">
                    <File
                        :name="`images.${index}.file`"
                        label="Image"
                        wrapperClasses="col-span-6"
                        v-model="form.images[index].file"
                        @update:modelValue="onImageInput"
                    />

                    <div class="col-span-6">
                        <TextArea
                            :name="`images.${index}.alt_text`"
                            label="Alt Text"
                            :rows="3"
                            v-model="form.images[index].alt_text"
                            maxlength="150"
                        />
                        <TextArea
                            :name="`images.${index}.attribution`"
                            label="Attribution"
                            :rows="2"
                            v-model="form.images[index].attribution"
                            maxlength="250"
                        />
                        <Text
                            :name="`images.${index}.source_url`"
                            label="Source URL"
                            v-model="form.images[index].source_url"
                            maxlength="250"
                        />
                    </div>
                </div>

                <div class="ll-form-row-grid">
                    <Text
                        :name="`images.${index}.license`"
                        label="License"
                        wrapperClasses="col-span-4"
                        v-model="form.images[index].license"
                        maxlength="50"
                    />
                    <Text
                        :name="`images.${index}.license_url`"
                        label="License URL"
                        wrapperClasses="col-span-8"
                        v-model="form.images[index].license_url"
                        maxlength="250"
                    />
                </div>
            </div>
        </section>

        <section>
            <h2>Street View Links</h2>

            <div
                v-for="(link, index) in form.street_view_links"
                class="ll-form-row-grid"
                @input="onStreetViewLinkInput"
            >
                <Text
                    :name="`street_view_links.${index}.title`"
                    label="Title"
                    wrapperClasses="col-span-4 !mb-0"
                    v-model="form.street_view_links[index].title"
                    :showLabel="!index"
                    maxlength="100"
                />
                <Text
                    :name="`street_view_links.${index}.url`"
                    label="URL"
                    wrapperClasses="col-span-8 !mb-0"
                    v-model="form.street_view_links[index].url"
                    :showLabel="!index"
                    maxlength="250"
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
                maxlength="50"
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
});

let submit = () => {
    // remove empty array elements
    ["images", "street_view_links"].forEach((key) => {
        form[key] = form[key].filter((obj) => !isObjectEmpty(obj));
    });

    router.post(route("snippets.store"), form);
};

// Images logic
let updateImageInputs = () => {
    let inputs = form.images;
    let last = inputs[inputs.length - 1];
    let nextToLast = inputs[inputs.length - 2];

    if (inputs.length > 1 && isObjectEmpty(last) && isObjectEmpty(nextToLast)) {
        inputs.pop();
    } else if (!last || !isObjectEmpty(last)) {
        inputs.push({
            file: null,
            alt_text: "",
            attribution: "",
            source_url: "",
            license: "",
            license_url: "",
        });
    }
};

let onImageInput = throttle(
    function () {
        updateImageInputs();
    },
    250,
    { leading: true, trailing: true },
);

updateImageInputs();

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
