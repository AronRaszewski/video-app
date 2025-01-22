<script setup>
import { Link } from '@inertiajs/vue3';
import { mdiAccountPlus, mdiClose, mdiHome, mdiListBox, mdiLogin, mdiLogout, mdiPlusBox, mdiWeatherNight, mdiWeatherSunny } from '@mdi/js';
import VideoSearch from '@/Components/VideoSearch.vue';
defineProps({
    isCollapsed: Boolean
})

const emit = defineEmits(['collapse'])
</script>
<template>
    <div id="aside" 
       class="fixed h-screen bg-gray-100 dark:bg-gray-800 text-sky-900 dark:text-sky-100 top-0 left-0 w-80 z-10 duration-300 border-r"
       :class="{'-translate-x-full': isCollapsed}"
       >
       <button @click="emit('collapse')">
        <svg-icon class="absolute right-3 top-3" type="mdi" :path="mdiClose" />
       </button>
        <h1 class="text-xl text-center border-b mb-3">Menu</h1>

        <template v-if="$page.props.auth.user">
            <p>Witaj, {{ $page.props.auth.user.name }}</p>
        </template>
        <template v-else>
            <p>Witaj, Gość!</p>
        </template>

        <nav class="flex flex-col justify-start gap-2 text-lg">
            <Link class="flex justify-start items-center" :href="route('dashboard')">
            <svg-icon type="mdi" :path="mdiHome" />
            Strona główna
            </Link>
            <Link class="flex justify-start items-center" :href="route('video.index')">
            <svg-icon type="mdi" :path="mdiListBox" />
            Lista
            </Link>
            <Link class="flex justify-start items-center" :href="route('video.create')" v-if="$page.props.auth.user">
            <svg-icon type="mdi" :path="mdiPlusBox" />
            Dodaj film
            </Link>


            <!-- User Menu (Login/Profile) -->
              <template v-if="$page.props.auth.user">
               
                <Link @click="router.post(route('logout'))" class="flex justify-start items-center" v-if="$page.props.auth.user">
                <svg-icon type="mdi" :path="mdiLogout" />
                Wyloguj się
                </Link>
              </template>
              <template v-else>
                <Link :href="route('login')" class="hover:underline">
                <svg-icon type="mdi" :path="mdiLogin" />
                </Link>
                <Link :href="route('register')" class="hover:underline">
                <svg-icon type="mdi" :path="mdiAccountPlus" />
                </Link>
              </template>

    
        </nav>

       </div>
</template>