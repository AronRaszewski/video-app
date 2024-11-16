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

        <Panel v-for="video in $page.props.videos">
            <template #header>
                <Link :href="route('video.show', video.id)">
                {{video.title}}
            </Link>
            </template>
        </Panel>
    </AppLayout>
</template>