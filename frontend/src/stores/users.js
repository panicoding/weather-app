import { defineStore } from "pinia"
import axios from 'axios'
import config from '@config'

export const useUsersStore = defineStore('users', {
    state: () => ({
        users: [],
        isLoading: true,
    }),
    actions: {
        async fetchUsers(page = 1) {
            try {
                const response = await axios.get(`${config.apiUrl}/users?page=${page}`)

                this.users = response.data
                this.isLoading = false
            } catch (error) {
                console.error(error)
            }
        }
    }
})