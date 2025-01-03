<template>
    <div class="border border-slate-400/20 p-2">
        <div class="font-bold my-1 text-zinc-300">
            {{ user.name ?? 'Unknown' }}
            <span class="ml-2 text-slate-500">{{ created_at }}</span>
        
        </div>
        <div>{{ content }}</div>
    </div>
</template>
<script setup>
const props = defineProps({
    user: {
        type: Object
    },
    content: {
        type: String,
        required: true,
    },
    created_at: {
        type: String 
    }
})
</script>