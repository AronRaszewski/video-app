<script setup>
import { mdiMagnify } from '@mdi/js';
import TextInput from './TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        
    }
})

const form = useForm({
    title: props.title
})

function submit()
{
    form.get(route('video.index'));
}
</script>

<template>
    <div class="relative">
        <form @submit.prevent="submit">
            <div class="absolute h-full left-1 flex items-center text-blue-500 dark:text-white pointer-events-none">
                <svg-icon type="mdi" :path="mdiMagnify" />
    
            </div>
            <TextInput class="pl-7" v-model="form.title" />

        </form>
    </div>
</template>