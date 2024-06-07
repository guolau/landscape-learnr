<template>
    <div class="ll-form-group" :class="[ classes, {'ll-input-error': $page.props.errors[name]} ]">
        <label :for="name">{{ label }}</label>
        <textarea :id="name" :name="name" 
            :rows="rows" 
            class="form-input"
            :class="{ 'll-html-editor !hidden': is_html_editor }"
            v-model="form[name]"></textarea>
        <component v-if="is_html_editor" 
            :is="CKEditor.component" :editor="ClassicEditor"
            v-model="form[name]"></component>
        <small :if="$page.props.errors[name]" class="text-rose-700">
            {{ $page.props.errors[name] }}
        </small>
    </div>
</template>

<script setup>
import { toTitleCase } from '@components/form/Utils.js';

import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const props = defineProps({
    name: String,
    label: { 
        type: String, 
        default(rawProps) {
            return toTitleCase(rawProps.name);
        }
    },
    rows: {
        type: Number,
        default: 10,
    },
    classes: String,
    is_html_editor: { 
        type: Boolean, 
        default: false,
    },
    form: Object,
});
</script>