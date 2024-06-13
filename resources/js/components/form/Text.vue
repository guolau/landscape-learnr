<template>
    <div
        class="ll-form-group"
        :class="[
            wrapperClasses,
            { 'll-input-error': $page.props.errors[name] },
        ]"
    >
        <label v-if="showLabel" :for="name">{{ label }}</label>
        <div class="flex">
            <input
                :id="name"
                :name="name"
                type="text"
                class="ll-form-input"
                :value="modelValue"
                :class="inputClasses"
                @input="$emit('update:modelValue', $event.target.value)"
            />
            <slot name="after"></slot>
        </div>
        <small :if="$page.props.errors[name]" class="text-rose-700">
            {{ $page.props.errors[name] }}
        </small>
    </div>
</template>

<script setup>
import { toTitleCase } from "@components/form/Utils.js";

const props = defineProps({
    name: String,
    label: {
        type: String,
        default(rawProps) {
            return toTitleCase(rawProps.name);
        },
    },
    wrapperClasses: String,
    inputClasses: String,
    modelValue: String,
    showLabel: {
        type: Boolean,
        default: true,
    },
});
</script>
