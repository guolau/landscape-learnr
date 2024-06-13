<template>
    <div
        @click="handler"
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
            accepted-file-types="image/jpeg, image/png"
            :storeAsFile="true"
            @input="onInput"
        />
        <small :if="$page.props.errors[name]" class="text-rose-700">
            {{ $page.props.errors[name] }}
        </small>
    </div>
</template>

<script setup>
import { toTitleCase } from "@components/form/Utils.js";
import { ref, onMounted } from "vue";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size";

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
    modelValue: File,
});

// Set up FilePond
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageValidateSize,
);

const pond = ref(null);

let onInput = () => {
    if (pond.value.getFile()) {
        emit("update:modelValue", pond.value.getFile().file);
    }
};
</script>

<style scoped></style>
