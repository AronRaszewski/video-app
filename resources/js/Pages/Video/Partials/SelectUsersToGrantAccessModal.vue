<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import Panel from '@/Components/Panel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { mdiMagnify } from '@mdi/js';
import axios from 'axios';
import { reactive, ref } from 'vue';

const props = defineProps({
    visible: {
        type: Boolean
    }
})

const emit = defineEmits('save');

const searchUsers = ref('');

async function fetchUsers()
{
    try {
        const res = await axios.get(route('search.users', {nickname: searchUsers.value}));
        console.log(res);
        const selected = users.filter(el => el.selected === true);
        const matched = res.data.map(({id, name}) => ({id, name, selected: false}))
        .filter(el => !selected.map(sel => sel.id).includes(el.id)); // Usuwam wyszukane elementy, które już są zaznaczone

        users.length = 0;

        for (let item of [...selected, ...matched]) {
            users.push(item);
        }

        console.log(users);


    } catch (err) {

    }
}

function save() {
    const selected = users.filter(el => el.selected);
    users.length = 0;
    for (let item of selected)
        users.push(item);
    emit('save', selected.map(el => el.id))
}

const users = reactive([]);
</script>

<template>
        <Modal :show="visible" >
        <Panel class="p-4">

            <h1>Wybierz użytkowników, którzy będą mogli obejrzeć ten film:</h1>
            <div class="w-full flex items-end gap-1">
                <div class="flex-1">
                    <InputLabel for="search-users">Wyszukaj użytkowników:</InputLabel>
                    <TextInput id="search-users" class="w-full" v-model="searchUsers" />

                </div>
                <div>
                    <PrimaryButton @click="fetchUsers">
                        <svg-icon type="mdi" :path="mdiMagnify" />
                    </PrimaryButton>
                </div>
    
            </div>
            <div>
                Użytkownicy:
                <div class="mx-6">
                    <div class="flex justify-between" v-for="user in users" :key="user.id">
                        <InputLabel :for="`select-user-id-${user.id}`">
                            {{ user.name }}
                        
                        </InputLabel>
                        <div>
                            <Checkbox :id="`select-user-id-${user.id}`" v-model="user.selected" :checked="user.selected" />
                        </div>
                    </div>
                </div>
            </div>
            <PrimaryButton @click="save">Zapisz</PrimaryButton>
        </Panel>
    </Modal>
</template>