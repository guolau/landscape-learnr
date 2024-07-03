<template>
    <div
        class="ll-form-group"
        :class="[classes, { 'll-input-error': $page.props.errors[name] }]"
    >
        <div class="flex items-center gap-2">
            <input
                :id="name"
                :name="name"
                type="checkbox"
                class="ll-form-input"
                v-model="proxyChecked"
                v-bind="$attrs"
            />
            <label :for="name" class="!mb-0"><slot /></label>
        </div>
        <small :if="$page.props.errors[name]" class="text-rose-700">
            {{ $page.props.errors[name] }}
        </small>
    </div>
</template>

<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    name: String,
    classes: String,
    modelValue: {
        Boolean,
        default: false,
    },
});

const proxyChecked = computed({
    get() {
        return props.modelValue;
    },

    set(val) {
        emit("update:modelValue", val);
    },
});
</script>
