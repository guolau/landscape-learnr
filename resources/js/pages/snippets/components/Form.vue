<template>
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <section>
            <h2>Title and Body</h2>

            <Text name="title" v-model="form.title" max-length="150" required />
            <HtmlEditor
                name="body_html"
                label="Body"
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
                        :name="`images.${index}.file_input`"
                        label="Image"
                        wrapperClasses="sm:col-span-6 col-span-12"
                        v-model="form.images[index].file_input"
                        @update:modelValue="onImageInput"
                        accepted-file-types="image/jpeg, image/png, image/gif"
                        max-file-size="512kb"
                        image-validate-size-min-width="500"
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
                            maxlength="500"
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
                        maxlength="500"
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
                    href="https://www.google.com/maps/@31.5236685,8.915214,3z?entry=ttu"
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
                    maxlength="500"
                />
            </div>
        </section>

        <section>
            <h2>Tags</h2>

            <p class="ll-input-hint !text-sm">
                You can manage tag descriptions and categories in the
                <a :href="$route('tags.index')" target="_blank">Tag Manager</a>.
            </p>

            <Text
                name="tags"
                label="Add Tag"
                wrapperClasses="max-w-sm"
                inputClasses="!rounded-r-none"
                v-model="tagInput"
                v-on:keydown.enter.prevent=""
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
                    class="py-2 pl-5 pr-2 bg-neutral-200 rounded-full"
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

        <section v-if="snippet.id">
            <h2>Revision</h2>

            <p class="ll-input-hint !text-sm">
                <strong>
                    Check this box if your changes affect a user's understanding
                    of this topic.
                </strong>
                For example, fixing incorrect information or adding additional
                supporting material. Don't check this for minor edits, like
                fixing typos or formatting. This will update the revision date
                and indicates to users that the content is up-to-date.
            </p>

            <Checkbox name="is_revised" v-model="form.is_revised">
                Mark this snippet as revised
            </Checkbox>
        </section>

        <button
            class="ll-btn-primary"
            type="submit"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
        >
            {{ submitText }}
        </button>
    </form>
</template>

<script setup>
import { ref } from "vue";
import Text from "@components/form/Text.vue";
import HtmlEditor from "@components/form/HtmlEditor.vue";
import TextArea from "@components/form/TextArea.vue";
import File from "@components/form/File.vue";
import Checkbox from "@components/form/Checkbox.vue";
import { updateExtraRows, filterEmptyRows } from "@components/form/Utils.js";
import throttle from "lodash/debounce";
import { Plus, Xmark } from "@iconoir/vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    snippet: {
        type: Object,
        default: {},
    },
    submitText: String,
    method: {
        type: String,
        required: true,
    },
    action: {
        type: String,
        required: true,
    },
});

const imageProps = [
    "file_input",
    "alt_text",
    "attribution",
    "source_url",
    "license",
    "license_url",
];

const streetViewLinkProps = ["title", "url"];

let form = useForm({
    title: props.snippet.title ?? "",
    body_html: props.snippet.body_html ?? "",
    images: props.snippet.images ?? [],
    street_view_links: props.snippet.street_view_links ?? [],
    tags: props.snippet.tags ?? [],
    _method: props.method,
    is_revised: false,
});

let submit = () => {
    form.images = filterEmptyRows(form.images, imageProps);
    form.street_view_links = filterEmptyRows(
        form.street_view_links,
        streetViewLinkProps,
    );

    form.post(props.action);
};

// Images logic
let onImageInput = throttle(
    function () {
        updateExtraRows(form.images, imageProps);
    },
    250,
    { leading: true, trailing: true },
);

updateExtraRows(form.images, imageProps);

// Street View Links logic
let onStreetViewLinkInput = throttle(
    function () {
        updateExtraRows(form.street_view_links, streetViewLinkProps);
    },
    250,
    { leading: true, trailing: true },
);

updateExtraRows(form.street_view_links, streetViewLinkProps);

// Tags logic
let tagInput = ref();

let onAddTag = () => {
    tagInput.value = tagInput.value?.trim();

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
