<script setup>
import Panel from '@/Components/Panel.vue';
import RateStars from '@/Components/RateStars.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    video: Object
})

</script>
<template>
    <AppLayout>
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
                    <RateStars :value="4.88" @submit="data => console.log(data)" />
                </div>
                <div>
                    Dodano: {{ video.created_at }}
                </div>
            </div>
       </Panel>
    </AppLayout>
</template>