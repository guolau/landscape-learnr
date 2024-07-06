<template>
    <main class="ll-panel mx-auto max-w-5xl">
        <div class="flex justify-between items-center">
            <h1>Edit Snippet</h1>
            <Link
                v-if="snippet.id"
                :href="$route('snippets.destroy', snippet)"
                method="delete"
                class="ll-btn-danger ll-btn-sm"
                as="button"
                @before="confirmDelete"
            >
                <TrashSolid height=".85em"></TrashSolid> Delete
            </Link>
        </div>
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
import { TrashSolid } from "@iconoir/vue";

const props = defineProps({
    snippet: Object,
});

let confirmDelete = () => {
    return confirm(
        "Are you sure you want to delete this snippet? This cannot be undone.",
    );
};
</script>
