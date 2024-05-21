import './bootstrap';
import { createApp } from "vue";

import Results from './components/Results.vue';

const app = createApp({});

app.component("results", Results);

app.mount("#app");