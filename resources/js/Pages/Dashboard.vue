<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { mdiHome } from '@mdi/js';
import Panel from '@/Components/Panel.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <AppLayout title="Dashboard">


        <Panel>
            <template #header>
                Witaj
            </template>
            Witaj w aplikacji Video App, w której możesz przechowywać filmy i dzielić się z innymi.
            <b v-if="!$page.props.auth.user">Załóż konto, aby przesyłać filmy</b>
        </Panel>

        <Panel>
            <template #header>
                Ostatnie filmy
            </template>

            <div class="grid gap-2 grid-cols-1 md:grid-cols-3">
                <div v-for="video in $page.props.last_videos">
                    <Link :href="route('video.show', video.id)" >{{ video.title }}</Link>
                    <div class="text-sm text-gray-500">
                    Autor: {{ video.author.name }}
                </div>
                </div>
            </div>
        </Panel>
    </AppLayout>
</template>
