<template>
    <Snippet :snippet="snippet"></Snippet>
</template>

<script setup>
import Snippet from "@components/Snippet.vue";

let props = defineProps({
    snippet: Object,
});
</script>
