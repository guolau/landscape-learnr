<template>
    <div
        class="ll-form-group"
        :class="[
            wrapperClasses,
            { 'll-input-error': $page.props.errors[name] },
        ]"
    >
        <label :for="name">{{ label }}</label>
        <file-pond
            :name="name"
            ref="pond"
            :value="modelValue"
            accepted-file-types="image/jpeg, image/png, image/gif"
            max-file-size="512kb"
            image-validate-size-min-width="500"
            :storeAsFile="!fallbackUrl"
            @updatefiles="onUpdateFiles"
            @init="handleFilePondInit"
            :filePosterFilterItem="fallbackUrl"
        />
        <small :if="$page.props.errors[name]" class="text-rose-700">
            {{ $page.props.errors[name] }}
        </small>
    </div>
</template>

<script setup>
import { toTitleCase } from "@components/form/Utils.js";
import { ref } from "vue";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    name: String,
    label: {
        type: String,
        default(rawProps) {
            return toTitleCase(rawProps.name);
        },
    },
    wrapperClasses: String,
    modelValue: Object,
    fallbackUrl: String,
});

// Set up FilePond
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageValidateSize,
    FilePondPluginFileValidateSize,
);

const pond = ref(null);

let handleFilePondInit = () => {
    if (props.fallbackUrl) {
        try {
            pond.value.addFile(props.fallbackUrl);
            pond.value.getFile().origin = "local"; // mark this file as already uploaded
        } catch {
            // if we can't load the file, that's fine. Do nothing
        }
    }
};

let onUpdateFiles = () => {
    let fileItem = pond.value.getFile();

    // if there's a file
    if (fileItem) {
        // and it's already on the server
        if (fileItem.origin == "local") {
            emit("update:modelValue", { file: null, action: null });
        } else {
            // and it's not already uploaded
            emit("update:modelValue", {
                file: fileItem.file,
                action: "create",
            });
        }
    } else {
        // there's no file
        if (props.fallbackUrl) {
            // but there was one already on the server
            emit("update:modelValue", { file: null, action: "delete" });
        } else {
            // and one wasn't already saved
            emit("update:modelValue", null);
        }
    }
};
</script>

<style scoped></style>
