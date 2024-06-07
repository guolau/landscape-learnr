<template>
    <form @submit.prevent="submit" enctype="multipart/form-data">
        <section>
            <h2>Title and Body</h2>

            <Text name="name" :form="form"/>
            <TextArea 
                name="body_html" 
                label="Body" 
                v-bind:is_html_editor="true" 
                :form="form"/>
        </section>

        <section>
            <h2>Image</h2>

            <div class="ll-form-row">
                <File name="image" classes="col-span-6" />

                <div class="col-span-6">
                    <TextArea name="alt_text" v-bind:rows="3" :form="form"/>
                    <TextArea name="attribution" v-bind:rows="2" :form="form"/>
                    <Text name="source_url" label="Source URL" :form="form"/>
                </div>
            </div>
            
            <div class="ll-form-row">
                <Text name="license" classes="col-span-4" :form="form"/>
                <Text name="license_url" label="License URL" classes="col-span-8" :form="form"/>
            </div>
        </section>
        
        <section>
            <h2>Street View Links</h2>
            
            <div class="ll-form-row">
                <Text name="street_view_links[0][title]" label="Title" classes="col-span-4" :form="form"/>
                <Text name="street_view_links[0][url]" label="URL" classes="col-span-8" :form="form"/>
            </div>
        </section>

        <section>
            <h2>Tags</h2>
        </section>        

        <button type="submit">Create Snippet</button>
    </form>
</template>

<script setup>
import Text from '@components/form/Text.vue';
import TextArea from '@components/form/TextArea.vue';
import File from '@components/form/File.vue';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';

let form = reactive({
    name: '',
    body_html: '',
});

let submit = () => {
    router.post(route('snippets.store'), form);
};
</script>