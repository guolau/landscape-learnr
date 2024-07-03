<template>
    <main class="ll-panel mx-auto max-w-5xl">
        <h1>Create Snippet</h1>
        <Form
            submitText="Create Snippet"
            method="post"
            :action="$route('snippets.store')"
        />
    </main>
</template>

<script setup>
import Form from "@pages/snippets/components/Form.vue";
</script>
