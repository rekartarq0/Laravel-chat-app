<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Chat',
        href: '/Chat',
    },
];



const props = defineProps({
    friend: Object,
    currentUser: Object,
    


});

const messages = ref([]);
const newMessageText = ref('');

function sendMessage() {
    if (newMessageText.value.trim() !== '') {
        axios.post(`/messages/${props.friend.id}`, {
         message:newMessageText.value,
        }).then((response) => {
            messages.value.push(response.data);
            newMessageText.value = '';
        });

    }

   
}


onMounted(() => {
    axios.get('/messages/' + props.friend.id).then((response) => {
        messages.value = response.data;
    });
})

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div v-if="props.friend" class="border-b bg-white p-3">
                {{ friend.name }}
            </div>
            <div class="p-6 bg-white border-b border-gray-200">

                <div class="container">
                    <div class="col-end-8">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Chat Component</h2>

                                <div class="flex justify-start text-red-500">
                                    current user
                                    {{ currentUser.name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat UI Markup -->
                <div class="flex h-[calc(100vh-250px)] flex-col">
                    <!-- Messages Area -->
                    <div class="flex-1 space-y-4 overflow-y-auto rounded-lg bg-gray-50 p-4">
                        <div v-for="message in messages" :key="message.id" class="flex"
                            :class="{ 'justify-end': message.sender_id === currentUser.id }">
                            <div class="max-w-xs rounded-lg p-3 lg:max-w-md" :class="{
                                'bg-blue-500 text-white': message.sender_id === currentUser.id,
                                'bg-gray-200 text-gray-800': message.sender_id !== currentUser.id,
                            }">
                                <p v-if="message.sender_id !== currentUser.id && props.friend"
                                    class="text-xs font-semibold text-gray-600">
                                    {{ props.friend.name }}
                                </p>
                                <p class="text-sm">{{ message.text }}</p>
                                <p class="mt-1 text-right text-xs" :class="{
                                    'text-blue-200': message.sender_id === currentUser.id,
                                    'text-gray-500': message.sender_id !== currentUser.id,
                                }">
                                    <!-- Optional timestamp or other message info can go here -->
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div class="mt-4 flex items-center">
                        <input v-model="newMessageText" @keyup.enter="sendMessage" type="text"
                            placeholder="Type your message..."
                            class="flex-1 rounded-l-lg border border-gray-300 p-3 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" />
                        <button @click="sendMessage"
                            class="rounded-r-lg bg-blue-500 p-3 px-6 text-white hover:bg-blue-600 focus:outline-none">
                            Send
                        </button>
                    </div>
                </div>


            </div>



        </div>
    </AppLayout>
</template>
