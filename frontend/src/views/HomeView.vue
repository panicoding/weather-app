<template>
  <div class="mx-auto max-w-7xl pb-12 px-2 sm:px-4">
    <div class="px-2 sm:px-6">
      <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
          <h1 class="text-base font-semibold leading-6 text-gray-900">User Weather</h1>
          <p class="mt-2 text-sm text-gray-700">A list of all the users weather data.</p>
        </div>
      </div>
      <div v-if="! usersStore.isLoading" class="mt-8 flow-root">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-300">
              <thead>
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Latitude</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Longitude</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3">
                    <span class="sr-only">View</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white">
                <tr v-for="(user, userIdx) in users.data" :key="user.id" :class="userIdx % 2 === 0 ? undefined : 'bg-gray-50'">
                  <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">{{ user.name }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ user.email }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ user.latitude }}</td>
                  <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ user.longitude }}</td>
                  <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3">
                    <a @click="viewWeatherData(user)" href="#" class="text-indigo-600 hover:text-indigo-900"
                      >View<span class="sr-only">, {{ user.name }}</span></a
                    >
                  </td>
                </tr>
              </tbody>
            </table>
            <TailwindPagination
              :data="users"
              @pagination-change-page="getResults"
            />
          </div>
        </div>
      </div>
    </div>

    <Modal :show="viewingWeatherData" @close="closeModal">
      <WeatherData :user="user"></WeatherData>
    </Modal>
  </div>
</template>

<script setup lang="ts">
import { nextTick, ref, computed } from 'vue';
import Modal from '@/components/Modal.vue'
import WeatherData from '@/components/WeatherData.vue'
import { useUsersStore } from '@store/users'
import { TailwindPagination } from 'laravel-vue-pagination';

const viewingWeatherData = ref(false)
const user = ref({})

const viewWeatherData = (u) => {
  viewingWeatherData.value = true;
  user.value = u
}

const closeModal = () => {
  viewingWeatherData.value = false;
}

const usersStore = useUsersStore()
usersStore.fetchUsers()

const users = computed(() => {
  return usersStore.users
});

const getResults = async (page = 1) => {
  usersStore.fetchUsers(page)
}
</script>