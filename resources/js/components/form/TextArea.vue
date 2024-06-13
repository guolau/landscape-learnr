<template>
    <div
        class="ll-form-group"
        :class="[
            wrapperClasses,
            { 'll-input-error': $page.props.errors[name] },
        ]"
    >
        <label :for="name">{{ label }}</label>
        <textarea
            v-if="!is_html_editor"
            :id="name"
            :name="name"
            :rows="rows"
            class="ll-form-input"
            :class="{ 'll-html-editor !hidden': is_html_editor }"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        ></textarea>
        <component
            v-if="is_html_editor"
            :is="CKEditor.component"
            :editor="ClassicEditor"
            v-model="ckeditorText"
            @input="$emit('update:modelValue', ckeditorText)"
        ></component>
        <small :if="$page.props.errors[name]" class="text-rose-700">
            {{ $page.props.errors[name] }}
        </small>
    </div>
</template>

<script setup>
import { toTitleCase } from "@components/form/Utils.js";
import { ref } from "vue";

import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const props = defineProps({
    name: String,
    label: {
        type: String,
        default(rawProps) {
            return toTitleCase(rawProps.name);
        },
    },
    modelValue: String,
    rows: {
        type: Number,
        default: 10,
    },
    wrapperClasses: String,
    is_html_editor: {
        type: Boolean,
        default: false,
    },
});

let ckeditorText = ref(props.modelValue);
</script>
