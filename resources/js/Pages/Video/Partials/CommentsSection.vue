<template>
    <header class="text-lg font-semibold">Komentarze ({{ comments.length }})</header>
    <form @submit.prevent="emit('submit-comment', writeComment); writeComment = ''">
        <header class="text-lg font-semibold">Napisz komentarz</header>
        <textarea class="w-full bg-gray-100 dark:bg-gray-900" placeholder="Treść komentarza" v-model="writeComment"></textarea>
        <PrimaryButton :disabled="writeComment.length === 0" type="submit" class="mt-2">Wyślij</PrimaryButton>
    </form>

    <Comment v-for="comment in comments" v-bind="comment"></Comment>

</template>
<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Comment from './Comment.vue';
import { ref } from 'vue';
const props = defineProps({
    comments: {
        type: Array,
        required: true
    }
})

const writeComment = ref('');

const emit = defineEmits(['submit-comment']);

</script>