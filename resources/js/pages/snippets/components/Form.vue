<template>
    <form
        @submit.prevent="submit"
        v-on:keydown.enter.prevent=""
        enctype="multipart/form-data"
    >
        <section>
            <h2>Title and Body</h2>

            <Text name="title" v-model="form.title" max-length="150" required />
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
                        wrapperClasses="sm:col-span-6 col-span-12"
                        v-model="form.images[index].file"
                        @update:modelValue="onImageInput"
                    />

                    <div class="sm:col-span-6 col-span-12">
                        <TextArea
                            :name="`images.${index}.alt_text`"
                            label="Alt Text"
                            :rows="3"
                            v-model="form.images[index].alt_text"
                            maxlength="150"
                        >
                            <template v-slot:hint
                                >Alternative text for this image. See this guide
                                on
                                <a
                                    href="https://accessibility.huit.harvard.edu/describe-content-images"
                                    target="_blank"
                                    >writing alt text</a
                                >.
                            </template>
                        </TextArea>
                        <TextArea
                            :name="`images.${index}.attribution`"
                            label="Attribution"
                            :rows="2"
                            v-model="form.images[index].attribution"
                            maxlength="250"
                        >
                            <template v-slot:hint
                                >Give credit to this image's creator. See this
                                guide on
                                <a
                                    href="https://wiki.creativecommons.org/wiki/Recommended_practices_for_attribution"
                                    target="_blank"
                                    >attribution</a
                                >.
                            </template>
                        </TextArea>
                        <Text
                            :name="`images.${index}.source_url`"
                            label="Source URL"
                            v-model="form.images[index].source_url"
                            maxlength="250"
                        >
                            <template v-slot:hint
                                >Link to where you found the image. Will be used
                                with the Attribution field.
                            </template>
                        </Text>
                    </div>
                </div>

                <div class="ll-form-row-grid">
                    <Text
                        :name="`images.${index}.license`"
                        label="License Name"
                        wrapperClasses="sm:col-span-4 col-span-12"
                        v-model="form.images[index].license"
                        maxlength="50"
                    />
                    <Text
                        :name="`images.${index}.license_url`"
                        label="License URL"
                        wrapperClasses="sm:col-span-8 col-span-12"
                        v-model="form.images[index].license_url"
                        maxlength="250"
                    />
                </div>
            </div>
        </section>

        <section>
            <h2>Street View Links</h2>

            <p class="ll-input-hint !text-sm">
                Include links to
                <a
                    href="https://www.google.com/maps/@-17.8751973,-70.1033153,3a,75y,20.74h,92.04t/data=!3m7!1e1!3m5!1sdystOSZj20URWDN4CDk1pw!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fpanoid%3DdystOSZj20URWDN4CDk1pw%26cb_client%3Dmaps_sv.tactile.gps%26w%3D203%26h%3D100%26yaw%3D349.01303%26pitch%3D0%26thumbfov%3D100!7i16384!8i8192?coh=205409&entry=ttu"
                    target="_blank"
                    >Google Street View</a
                >
                that show examples of this snippet's topic. Visit
                <a
                    href="https://www.google.com/maps/@33.0099493,-44.3465048,3z?entry=ttu"
                    target="_blank"
                    >Google Maps</a
                >
                to get started.
            </p>

            <div
                v-for="(link, index) in form.street_view_links"
                class="ll-form-row-grid"
                @input="onStreetViewLinkInput"
            >
                <Text
                    :name="`street_view_links.${index}.title`"
                    label="Title"
                    wrapperClasses="sm:col-span-4 col-span-6 !mb-0"
                    v-model="form.street_view_links[index].title"
                    :showLabel="!index"
                    maxlength="100"
                />
                <Text
                    :name="`street_view_links.${index}.url`"
                    label="URL"
                    wrapperClasses="sm:col-span-8 col-span-6 !mb-0"
                    v-model="form.street_view_links[index].url"
                    :showLabel="!index"
                    maxlength="250"
                />
            </div>
        </section>

        <section>
            <h2>Tags</h2>

            <p class="ll-input-hint !text-sm">
                You can manage tag descriptions and categories in the
                <a href="" target="_blank">Tag Manager</a> (coming soon).
            </p>

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
    tagInput.value = tagInput.value.trim();

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
