<template>
    <Head title="Log in" />

    <main class="ll-panel mx-auto max-w-xl">
        <h1>Log In</h1>

        <form @submit.prevent="submit">
            <Text name="email" v-model="form.email" max-length="255" required />
            <Text
                name="password"
                v-model="form.password"
                type="password"
                max-length="255"
                autocomplete="current-password"
                required
            />

            <Checkbox name="remember" v-model="form.remember"
                >Remember me</Checkbox
            >

            <button
                class="ll-form-group ll-btn-primary"
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Log in
            </button>
        </form>
    </main>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Text from "@components/form/Text.vue";
import Checkbox from "@components/form/Checkbox.vue";

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>
