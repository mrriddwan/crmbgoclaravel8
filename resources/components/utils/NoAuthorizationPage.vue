<template>
    <div
        class="container bg-amber-500 h-screen items-center text-center align-middle"
    >
        <div class="py-10 px-64 font-mono">
            <div class="border-8 border-red-600 my-5 mx-auto">
                <h1 class="uppercase text-red-600 font-extrabold text-9xl">
                    403
                </h1>
            </div>

            <div class="w-max text-left mx-auto">
                <h1 class="uppercase text-white font-extrabold text-8xl">
                    Not Allowed
                </h1>
            </div>
            <ExclamationTriangleIcon class="h-60 w-60 text-red-600 mx-auto" />
        </div>
    </div>
</template>

<script>
import { ExclamationTriangleIcon } from "@heroicons/vue/24/solid";

export default {
    components: { ExclamationTriangleIcon },
};
</script>
