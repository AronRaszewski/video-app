<script setup>
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import Panel from '@/Components/Panel.vue';
import Dropzone from 'dropzone';
import { onMounted, reactive } from 'vue';
import { mdiUpload } from '@mdi/js';

let dropzone;

const form = useForm({
    title: '',
    file: null,
    description: ''
})

onMounted(() => {
    dropzone = new Dropzone('div#video-dropzone', {
        maxFiles: 1,
        url: route('video.store'),
        addRemoveLinks: true,
        autoProcessQueue: false,
        chunking: true,
        chunkSize: 1024*1024*2, // 2 MB
        init() {
            this.on('addedfile', file => {
                console.log(file);
                form.file = file;
            })
        }
    });
})

function submit() {
    const formData = new FormData();

    formData.append('title', form.title);
    formData.append('description', form.description);
    if (form.file) {
        formData.append('file', form.file);
    }

    router.post(route('video.store'), formData, {
        forceFormData: true
    })

}
</script>

<template>
    <AppLayout title="Dashboard">
        <Panel>
            <template #header>
                Dodaj nowe video
            </template>
            <form @submit.prevent="submit" class="grid grid-cols-2 gap-2">
                
                <div class="text-right">
                    <InputLabel class="my-auto" for="upload-title">Tytuł</InputLabel>

                </div>
                <div>
                    <TextInput id="upload-title" class="w-72" v-model="form.title" />
                    <InputError :message=form.errors.title />

                </div>
                <div class="text-right">
                    <InputLabel for="description">Opis</InputLabel>
                </div>
                <div>
                    <textarea class="w-72 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    id="description" v-model="form.description"></textarea>
                </div>
                <div class="text-right">
                    <InputLabel for="upload-file">Film</InputLabel>

                </div>
                <div>
                    <!--
                        <input type="file" accept=".mp3, .wav, .avi, .mp4" @input="form.file = $event.target.files[0]" />
                    
                    -->
                    
                    <div id="video-dropzone" class="w-72 h-48 border rounded flex flex-col items-center justify-center border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        <svg-icon type="mdi" :path="mdiUpload" />
                    </div>
                    
                    <InputError :message=form.errors.file />
                </div>
                
                <div class="col-start-2">
                    <PrimaryButton type="submit">Wyślij</PrimaryButton>

                </div>
            </form>
        </Panel>
    </AppLayout>
</template>