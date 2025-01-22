<script setup>
import Panel from '@/Components/Panel.vue';
import RateStars from '@/Components/RateStars.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';
import CommentsSection from './Partials/CommentsSection.vue';

const {video, already_rated} = defineProps({
    video: {
        type: Object,
        required: true
    },
    already_rated: Number
})

async function deleteRate() {
    if (confirm('Na pewno chcesz usunąć ocenę?')) {
        let response = await axios.delete(route('ratings.destroy', [video.id]))
        router.reload();
        alert(response.data.message);
    }
}

async function saveRate(rate)
{
    let response;
    try {
        const data = { rate: rate };
        response = await axios.post(route('ratings.rate', [video.id]), data)

        /*

        switch (already_rated) {
            case null:
            // nie wystawiono oceny - dodaj ją
            break;
            case rate:
            // ta sama liczba gwiazdek - usuń ocenę
            if (confirm('Na pewno chcesz usunąć ocenę?')) {
                response = await axios.delete(route('ratings.store', [video.id]), data)
            }
            break;
            default:
            // inna ocena - zmień ją
            response = await axios.put(route('ratings.store', [video.id]), data)
    
        }
            */
        router.reload();
        alert(response.data.message);
        

    } catch (error) {
        console.log(error);
        switch (error.response.status) {
            case 401:
                alert('Aby ocenić film należy się zalogować');
                break;
            case 403:
                alert(error.response.data.message);
                break;
            default:
                alert('Wystąpił błąd, skontaktuj się z administratorem')
        }

    }
}

async function saveComment(data)
{
    try {
        const res = await axios.post(route('comments.store', {video: video.id}), { content: data });
        router.reload();

    } catch (err) {
        alert('Wystąpił błąd')
        console.log(err);
    }

}

</script>
<template>
    <AppLayout>
        <div class="grid md:grid-cols-[60%_40%]">
            <Panel>
                 <template #header>
                     {{ video.title }}
                 </template>
     
                 <video controls class="mx-auto">
                     <source  :src="video.url"/>
                     Wystąpił błąd.
                 </video>
                 <div v-if="video.description">
                     Opis: {{ video.description }}
                 </div>
                 <div class="text-sm flex justify-between">
                     <div>
                         Autor: {{ video.author.name }}
     
                     </div>
                     <div>
                         <RateStars :value="video.rates_avg_rate" @submit="saveRate" />
                         <div v-if="already_rated">
     
                             Twoja ocena: {{ already_rated }} <button href="#" @click="deleteRate()" class="text-blue-300">Usuń</button>
                         </div>
                     </div>
                     <div>
                         Dodano: {{ video.created_at }}
                     </div>
                 </div>
            </Panel>
            <Panel>
                 <CommentsSection :comments="video.comments" @submit-comment="content => saveComment(content)" />
            </Panel>

        </div>
    </AppLayout>
</template>