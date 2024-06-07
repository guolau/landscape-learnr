<template>
    <div class="ll-form-group" :class="[ classes, {'ll-input-error': $page.props.errors[name]} ]">
        <label :for="name">{{ label }}</label>
        <file-pond :name="name" />
        <small :if="$page.props.errors[name]" class="text-rose-700">
            {{ $page.props.errors[name] }}
        </small>
    </div>
</template>

<script setup>
import { toTitleCase } from '@components/form/Utils.js';

const props = defineProps({
    name: String,
    label: { 
        type: String, 
        default(rawProps) {
            return toTitleCase(rawProps.name);
        }
    },
    classes: String,
    form: Object,
});

import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginImageValidateSize
);
</script>

<style scoped></style>