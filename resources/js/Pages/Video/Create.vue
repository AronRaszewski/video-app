<script setup>
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Panel from '@/Components/Panel.vue';
const form = useForm({
    title: '',
    file: null
})

function submit() {
    form.post(route('video.store'));
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
                    <TextInput id="upload-title" v-model="form.title" />
                    <InputError :message=form.errors.title />

                </div>
                <div class="text-right">
                    <InputLabel for="upload-file">Film</InputLabel>

                </div>
                <div>
                    <input type="file" accept=".mp3, .wav, .avi, .mp4" @input="form.file = $event.target.files[0]" />
                    <InputError :message=form.errors.file />
                </div>
                <div class="col-start-2">
                    <PrimaryButton type="submit">Wyślij</PrimaryButton>

                </div>
            </form>
        </Panel>
    </AppLayout>
</template>