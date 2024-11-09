<template>
    <div
        class="ll-form-group"
        :class="[
            wrapperClasses,
            { 'll-input-error': $page.props.errors[name] },
        ]"
    >
        <label v-if="showLabel" :for="name">{{ label }}</label>
        <p class="ll-input-hint"><slot name="hint"></slot></p>
        <div class="flex">
            <select
                :id="name"
                :name="name"
                class="ll-form-input"
                :value="modelValue"
                :class="inputClasses"
                @input="$emit('update:modelValue', $event.target.value)"
                v-bind="$attrs"
            >
                <option v-if="includeEmptyOption" value="">
                    {{ emptyOptionLabel }}
                </option>
                <option v-for="option in options" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
            <slot name="after"></slot>
        </div>
        <small :if="$page.props.errors[name]" class="text-rose-700">
            {{ $page.props.errors[name] }}
        </small>
    </div>
</template>

<script setup>
import { toTitleCase } from "@components/Utils.js";

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

    // if true, add a blank option at the beginning of the options list
    includeEmptyOption: {
        type: Boolean,
        default: true,
    },
    emptyOptionLabel: {
        type: String,
        default: "Select option",
    },

    // contains an array of Objects, one for each option. Each object should have a value and label property.
    options: Array,
});

defineOptions({
    inheritAttrs: false,
});
</script>
