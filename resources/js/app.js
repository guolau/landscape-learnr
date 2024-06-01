import './bootstrap';
import { createApp } from "vue";

import Results from './components/Results.vue';
import Snippet from './components/Snippet.vue';

const app = createApp({});

app.component("Results", Results);
app.component("Snippet", Snippet);

app.mount("#app");