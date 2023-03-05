<template>
  <div class="min-h-full">
    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
        <Popover class="flex h-16 justify-between" v-slot="{ open }">
          <div class="flex px-2 lg:px-0">
            <div class="flex flex-shrink-0 items-center">
              <a href="#">
                <img class="h-8 w-auto" src="https://img.icons8.com/fluency/256/rainy-weather.png" alt="Your Company" />
              </a>
            </div>
            <nav aria-label="Global" class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-4">
              <RouterLink
                v-for="item in navigation"
                :key="item.href"
                :to="item.href"
                class="px-3 py-2 text-sm font-medium text-gray-900">
                {{ item.name }}
              </RouterLink>
            </nav>
          </div>
          <div class="flex flex-1 items-center justify-center px-2 lg:ml-6 lg:justify-end">
            <div class="w-full max-w-lg lg:max-w-xs">
              <label for="search" class="sr-only">Search</label>
              <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                  <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </div>
                <input id="search" name="search" class="block w-full rounded-md border-0 bg-white py-1.5 pl-10 pr-3 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" placeholder="Search" type="search" />
              </div>
            </div>
          </div>
          <div class="flex items-center lg:hidden">
            <PopoverButton class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
              <span class="sr-only">Open main menu</span>
              <Bars3Icon class="block h-6 w-6" aria-hidden="true" />
            </PopoverButton>
          </div>
          <TransitionRoot as="template" :show="open">
            <div class="lg:hidden">
              <TransitionChild as="template" enter="duration-150 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-150 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <PopoverOverlay class="fixed inset-0 z-20 bg-black bg-opacity-25" aria-hidden="true" />
              </TransitionChild>

              <TransitionChild as="template" enter="duration-150 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-150 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                <PopoverPanel focus class="absolute top-0 right-0 z-30 w-full max-w-none origin-top transform p-2 transition">
                  <div class="divide-y divide-gray-200 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="pt-3 pb-2">
                      <div class="flex items-center justify-between px-4">
                        <div>
                          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=blue&shade=600" alt="Your Company" />
                        </div>
                        <div class="-mr-2">
                          <PopoverButton class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <span class="sr-only">Close menu</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                          </PopoverButton>
                        </div>
                      </div>
                      <div class="mt-3 space-y-1 px-2">
                        <a v-for="item in navigation" :key="item.name" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">{{ item.name }}</a>
                      </div>
                    </div>
                    <div class="pt-4 pb-2">
                      <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                          <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt="" />
                        </div>
                        <div class="ml-3">
                          <div class="text-base font-medium text-gray-800">{{ user.name }}</div>
                          <div class="text-sm font-medium text-gray-500">{{ user.email }}</div>
                        </div>
                        <button type="button" class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                          <span class="sr-only">View notifications</span>
                          <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>
                      </div>
                      <div class="mt-3 space-y-1 px-2">
                        <a v-for="item in userNavigation" :key="item.name" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">{{ item.name }}</a>
                      </div>
                    </div>
                  </div>
                </PopoverPanel>
              </TransitionChild>
            </div>
          </TransitionRoot>
          <div class="hidden lg:ml-4 lg:flex lg:items-center">
            <button type="button" class="flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              <span class="sr-only">View notifications</span>
              <BellIcon class="h-6 w-6" aria-hidden="true" />
            </button>

            <Menu as="div" class="relative ml-4 flex-shrink-0">
              <div>
                <MenuButton class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  <span class="sr-only">Open user menu</span>
                  <img class="h-8 w-8 rounded-full" :src="user.imageUrl" alt="" />
                </MenuButton>
              </div>
              <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                  <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                    <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                  </MenuItem>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </Popover>
      </div>
    </header>

    <main class="py-10">
      <RouterView />
    </main>
  </div>
</template>

<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";
import {
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  Popover,
  PopoverButton,
  PopoverOverlay,
  PopoverPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  CheckIcon,
  HandThumbUpIcon,
  MagnifyingGlassIcon,
  UserIcon,
} from '@heroicons/vue/20/solid'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const user = {
  name: 'John Doe',
  email: 'joendoe@website.com',
  imageUrl:
    'https://images.unsplash.com/photo-1518020382113-a7e8fc38eac9?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=717&q=80',
}
const navigation = [
  { name: 'Home', href: '/' },
]
const breadcrumbs = [
  { name: 'Jobs', href: '#', current: false },
  { name: 'Front End Developer', href: '#', current: false },
  { name: 'Applicants', href: '#', current: true },
]
const userNavigation = [
  { name: 'Your Profile', href: '#' },
  { name: 'Settings', href: '#' },
  { name: 'Sign out', href: '#' },
]
</script>

<style scoped>

</style>
