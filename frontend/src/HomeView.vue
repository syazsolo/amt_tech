<template>
    <div class="p-4">
        <div class="mb-4 flex justify-center items-center">
            <input type="text" v-model="filter" placeholder="Filter users by name..."
                class="border border-gray-300 rounded px-3 py-2 w-1/2" />
        </div>

        <div v-if="isLoading === false" class="flex flex-col">
            <div v-if="users.length === 0">
                No user
            </div>
            <div v-else class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-4">ID</th>
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4">Email</th>
                                    <th scope="col" class="px-6 py-4">Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in filteredUsers" :key="user.id"
                                    class="border-b border-neutral-200 dark:border-white/10">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ user.id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ user.name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ user.email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ user.phone }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const users = ref([]);
const filter = ref('');
const isLoading = ref(true);

onMounted(async () => {
    try {
        const response = await axios.post(`${process.env.VUE_APP_API_URL}/api/user/all`);
        users.value = response.data;
    } catch (error) {
        console.error('Error fetching users:', error);
    } finally {
        isLoading.value = false;
    }
});

const filteredUsers = computed(() => {
    const filterText = filter.value.toLowerCase();
    return users.value.filter(user => user.name.toLowerCase().includes(filterText));
});
</script>