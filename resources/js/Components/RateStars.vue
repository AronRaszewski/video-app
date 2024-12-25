<script setup>
import { mdiStar, mdiStarHalf } from '@mdi/js';
import { computed } from 'vue';

const {value} = defineProps({
    value: {
        type: Number
    }
})

const halfStar = computed(() => {
    return (value - Math.floor(value)) >= 0.5
})


const emit = defineEmits(['submit'])
</script>
<template>
    <div class="flex items-center gap-2">
        <div class="relative">
            <div class="text-gray-950/50 flex">
                <svg-icon v-for="i in 5" type="mdi" :path="mdiStar" />
            </div>
            <div class="absolute inset-0 text-blue-500 dark:text-sky-200 flex">
                <svg-icon v-for="i in Math.floor(value)" type="mdi" :path="mdiStar" />
                <svg-icon v-if="halfStar" type="mdi" :path="mdiStarHalf" />
                
            </div>
            <div class="absolute inset-0 text-amber-400 flex flex-row-reverse">
                <svg-icon v-for="i in 5" type="mdi" class="peer duration-100 opacity-0 peer-hover:opacity-100 hover:opacity-100 hover:cursor-pointer" :path="mdiStar" @click="emit('submit', 6-i)" />
            </div>
        </div>
        <div class="text-sm text-slate-600 dark:text-slate-400">
            {{ value }} / 5.00
        </div>
    </div>
</template>