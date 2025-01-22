<template>
  <div :class="{ dark: isDarkMode }">

    <!-- Menu Aside -->
    <AsideMenu :is-collapsed="menuCollapsed" @collapse="toggleMenuCollapsed" />

    <div
      class="min-h-screen flex flex-col bg-white dark:bg-gray-900 text-black dark:text-white transition-colors duration-300">
      <!-- Header -->
      <header class="bg-blue-600 dark:bg-gray-800 text-white shadow-md fixed top-0 inset-x-0 w-full">
        <div class="px-4 py-4 flex items-center justify-between flex-wrap ">



          <!-- Navigation Links -->
          <button @click="toggleMenuCollapsed">
            <svg-icon type="mdi" :path="mdiMenu" />

          </button>

          <!-- Logo -->
            <h1 class="text-2xl font-bold">
              <Link href="/" class="hover:underline">
              VideoApp
              </Link>
            </h1>
            
            <VideoSearch v-bind="$page.props.query" />
            

            <!-- Dark Mode Toggle -->
            <button @click="toggleDarkMode"
              class="ml-4 p-2 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-50">
              <svg-icon type="mdi" :path="isDarkMode ? mdiWeatherNight : mdiWeatherSunny" />
            </button>



        </div>
      </header>

      <!-- Main Content -->
      <main class="flex-grow container mx-auto px-4 py-6 mt-16">
        <slot></slot>
      </main>

      <!-- Footer -->
      <footer class="bg-gray-800 dark:bg-gray-900 text-white py-4">
        <div class="container mx-auto text-center">
          <p>&copy; 2024 VideoApp. All Rights Reserved.</p>
          <div class="mt-2 space-x-4">
            <Link href="/terms" class="hover:underline">Terms of Service</Link>
            <Link href="/privacy" class="hover:underline">Privacy Policy</Link>
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { mdiAccountKey, mdiAccountPlus, mdiHome, mdiListBox, mdiLogin, mdiLogout, mdiMenu, mdiPlusBox, mdiWeatherNight, mdiWeatherSunny } from '@mdi/js';
import VideoSearch from '@/Components/VideoSearch.vue';
import AsideMenu from './Partials/AsideMenu.vue';

const menuCollapsed = ref(true);

// State for dark mode
const isDarkMode = ref(false);

const toggleMenuCollapsed = () => {
  menuCollapsed.value = !menuCollapsed.value;
}

// Method to toggle dark mode
const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  // Store the preference in localStorage
  localStorage.setItem('darkMode', isDarkMode.value ? 'enabled' : 'disabled');
};

// Load dark mode preference from localStorage on mount
onMounted(() => {
  const darkModePreference = localStorage.getItem('darkMode');
  if (darkModePreference === 'enabled') {
    isDarkMode.value = true;
  }
});
</script>

<style scoped>
/* Custom styles if needed */
</style>