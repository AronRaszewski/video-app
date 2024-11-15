<template>
    <div :class="{dark: isDarkMode}">

        <div class="min-h-screen flex flex-col bg-white dark:bg-gray-900 text-black dark:text-white transition-colors duration-300">
          <!-- Header -->
          <header class="bg-blue-600 dark:bg-gray-800 text-white shadow-md fixed top-0 inset-x-0">
            <div class="container mx-auto px-4 py-4 flex items-center justify-between">
              <!-- Logo -->
              <h1 class="text-2xl font-bold">
                <Link href="/" class="hover:underline">
                  VideoApp
                </Link>
              </h1>
      
              <!-- Navigation Links -->
              <nav class="space-x-4">
                <Link href="/" class="hover:underline">Home</Link>
                <Link href="/categories" class="hover:underline">Categories</Link>
                <Link href="/playlists" class="hover:underline">Playlists</Link>
                <Link :href="route('video.create')" class="hover:underline" v-if="$page.props.auth.user">
                  Dodaj
                </Link>
              </nav>
      
              <!-- Dark Mode Toggle -->
              <button @click="toggleDarkMode" class="ml-4 p-2 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-50">
                <svg-icon type="mdi" :path="isDarkMode ? mdiWeatherNight : mdiWeatherSunny " />
              </button>
      
              <!-- User Menu (Login/Profile) -->
              <div class="flex items-center space-x-4">
                <template v-if="$page.props.auth.user">
                <p>Witaj, {{$page.props.auth.user.name}}</p>
                <Link @click="router.post(route('logout'))" class="hover:underline" v-if="$page.props.auth.user">
                    <svg-icon type="mdi" :path="mdiLogout" />
                </Link>
                </template>
                <template>
                  <Link :href="route('login')" class="hover:underline">
                      <svg-icon type="mdi" :path="mdiLogin"/>
                  </Link>
                  <Link :href="route('register')" class="hover:underline">
                      <svg-icon type="mdi" :path="mdiAccountPlus" />
                  </Link>
                </template>

              </div>
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
import { mdiAccountKey, mdiAccountPlus, mdiLogin, mdiLogout, mdiWeatherNight, mdiWeatherSunny } from '@mdi/js';

  
  // State for dark mode
  const isDarkMode = ref(false);
  
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
  