<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];


const props = defineProps({
    user: Array, // Ensure type matches Laravel's response
});

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">


            <!-- {{ user }} -->

            <div v-for="users in user" :key="users.id" class="grid grid-cols-2 gap-4">
                <a :href="route('chat', users.id)">
                    {{ users.name }}
                    {{ users.email }}

                    {}

                </a>
            </div>

        </div>
    </AppLayout>
</template>
