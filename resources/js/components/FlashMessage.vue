<template>
    <div
        v-if="message"
        class="ll-flash-msg transition-opacity duration-500"
        :class="[
            `ll-flash-msg-${status}`,
            { 'opacity-100': show },
            { 'opacity-0': !show },
        ]"
    >
        <InfoCircle v-if="status == 'info'"></InfoCircle>
        <WarningTriangle v-if="status == 'danger'"></WarningTriangle>
        <CheckCircle v-if="status == 'success'"></CheckCircle>
        {{ message }}
        <button
            class="ml-auto mr-0 rounded-full py-0 px-1 ml-1"
            @click="show = false"
        >
            <Xmark></Xmark>
        </button>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { InfoCircle, WarningTriangle, CheckCircle, Xmark } from "@iconoir/vue";

const props = defineProps({
    message: {
        type: String,
        default: "",
    },
    status: String,
});

let show = ref(true);

// automatically dismiss success messages after certain amount of time
let dismissSuccessMsg = (message) => {
    if (props.message && props.status == "success") {
        setTimeout(() => {
            show.value = false;
        }, 4000);
    }
};

dismissSuccessMsg();

watch(
    () => props.message,
    async (newMessage, oldMessage) => {
        show.value = true;
        dismissSuccessMsg();
    },
);
</script>
