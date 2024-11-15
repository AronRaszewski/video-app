<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { mdiHome } from '@mdi/js';
import Panel from '@/Components/Panel.vue';
</script>

<template>
    <AppLayout title="Dashboard">


        <Panel>
            <template #header>
                Nagłówek
            </template>
            Test panelu
        </Panel>
    </AppLayout>
</template>
