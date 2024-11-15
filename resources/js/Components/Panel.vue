<template>
    <div class="p-3 border-1 border-white rounded bg-zinc-100 dark:bg-slate-800">
        <header v-if="$slots.header" class="text-xl text-blue-600 dark:text-blue-400 font-bold text-center mb-2">
            <slot name="header" />
        </header>
        <slot />
    </div>
</template>