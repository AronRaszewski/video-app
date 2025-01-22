<script setup>
import { mdiClose, mdiMagnify } from '@mdi/js';
import TextInput from './TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    title: {
        type: String,
        
    }
})

const mobileCollapsed = ref(true);

const form = useForm({
    title: props.title
})

function submit()
{
    form.get(route('video.index'));
}
</script>

<template>
    <button class=" md:hidden" @click="mobileCollapsed = false">
        <svg-icon type="mdi" :path="mdiMagnify" />
    </button>
    <div class="fixed z-10 top-0 inset-x-0 flex md:static py-4 bg-black/80 md:bg-transparent" :class="{'hidden md:flex': mobileCollapsed}">
        <form @submit.prevent="submit" class="flex-grow relative ">
            <div class="absolute h-full left-1 flex items-center text-blue-500 dark:text-white pointer-events-none">
                <svg-icon type="mdi" :path="mdiMagnify" />
    
            </div>
            <TextInput class="pl-7 w-full" v-model="form.title" placeholder="Szukaj" />

        </form>
        <button class=" md:hidden" @click="mobileCollapsed = true;">
            <svg-icon type="mdi" :path="mdiClose" class="" />
        </button>
    </div>
</template>