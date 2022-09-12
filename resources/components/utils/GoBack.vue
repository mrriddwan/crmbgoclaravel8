<template>
    <span class="go-back">
        <button
            @click="goBack"
            class="inline-flex items-center px-1 py-1 mt-2 mb-2 rounded-md font-semibold text-xs text-white uppercase"
        >
            <ArrowLeftCircleIcon class="h-5 w-5"/>
        </button>
    </span>
</template>

<script>
import { ArrowLeftCircleIcon } from "@heroicons/vue/24/solid";

export default {
    components: { ArrowLeftCircleIcon },
    methods: {
        goBack() {
            return this.$router.go(-1);
        },
    },
};
</script>

<style scoped>
.go-back {
    display: flex;
    cursor: pointer;
}

button {
    background-color: rgb(20 184 166);
    border-color: black;
}
</style>
