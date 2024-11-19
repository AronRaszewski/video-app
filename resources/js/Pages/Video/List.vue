<script setup>
import Panel from '@/Components/Panel.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="grid lg:grid-cols-3 gap-1">
            <Panel v-if="$page.props.videos.length > 0" v-for="video in $page.props.videos">
                <template #header>
                    <Link :href="route('video.show', video.id)">
                    {{video.title}}
                </Link>
                </template>
                {{ video.description }}
                <div class="text-sm text-gray-500">
                    Autor: {{ video.author.name }}
                </div>
            </Panel>
            <Panel class="col-span-full" v-else>
                Brak video. Możesz przesłać swoje video!
            </Panel>
            
        </div>
    </AppLayout>
</template>