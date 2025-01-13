<script setup>
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Panel from '@/Components/Panel.vue';
import Dropzone from 'dropzone';
import { computed, onMounted, reactive, ref } from 'vue';
import { mdiMagnify, mdiPlusCircle, mdiUpload } from '@mdi/js';
import Cookie from 'js-cookie';
import Modal from '@/Components/Modal.vue';
import Checkbox from '@/Components/Checkbox.vue';
import SelectUsersToGrantAccessModal from './Partials/SelectUsersToGrantAccessModal.vue';

let dropzone;

const form = useForm({
    title: '',
    file: '',
    description: '',
    visibility: 'public',
    grantAccessTo: []
})

const selectUsersModalVisible = ref(false);



const visibilityTip = computed(() => {
    return {
        'public': 'Widoczny dla wszystkich',
        'restricted': 'Widoczny dla wybranych użytkowników',
        'private': 'Widoczny tylko dla Ciebie'
    }[form.visibility];
})


onMounted(() => {
    dropzone = new Dropzone('div#video-dropzone', {
        maxFiles: 1,
        url: route('video.upload'),
        headers: {
            'X-XSRF-TOKEN': Cookie.get('XSRF-TOKEN')
        },
        chunking: true,
        chunkSize: 1024*1024*2, // 2 MB
        acceptedFiles: 'video/*',
        init() {
            this.on('success', file => {
                form.file = file.xhr.response;
            })
        }
    });
})

function submit() {
    form.post(route('video.store'));

}

function save(data) {
    form.grantAccessTo = data;
    selectUsersModalVisible.value = false;
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

                <div class="text-right">
                    <InputLabel for="visibility">Widoczność</InputLabel>
                </div>
                <div>
                    
                    <select id="visibility" class="dark:bg-slate-900" v-model="form.visibility">
                        <option value="public">Publiczny</option>
                        <option value="restricted">Ograniczony</option>
                        <option value="private">Prywatny</option>
                    </select>
                    <div class="flex gap-1">{{ visibilityTip }} <template v-if="form.visibility === 'restricted'">({{ form.grantAccessTo.length }})</template>
                        <button class="flex gap-1 text-blue-700 dark:text-blue-300" type="button" v-if="form.visibility === 'restricted'" @click="selectUsersModalVisible = true">
                            <svg-icon type="mdi" :path="mdiPlusCircle" />
                            Kliknij aby wybrać
                        </button>
                    
                    </div>
                </div>
                
                <div class="col-start-2">
                    <PrimaryButton type="submit">Wyślij</PrimaryButton>

                </div>
            </form>
        </Panel>
    </AppLayout>
    <SelectUsersToGrantAccessModal :visible="selectUsersModalVisible" @save="save" />
</template>