<template>
    <main class="ll-panel mx-auto max-w-5xl">
        <h1>Edit Snippet</h1>
        <Form
            :snippet="snippet"
            method="patch"
            :action="$route('snippets.update', snippet)"
            submitText="Save Snippet"
        />
    </main>
</template>

<script setup>
import Form from "@pages/snippets/components/Form.vue";

const props = defineProps({
    snippet: Object,
});
</script>
