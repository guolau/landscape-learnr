<template>
    <div class="ll-form-group" :class="[ classes, {'ll-input-error': $page.props.errors[name]} ]">
        <label :for="name">{{ label }}</label>
        <input :id="name" :name="name" 
            type="text" 
            class="form-input"
            v-model="form[name]">
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
</script>