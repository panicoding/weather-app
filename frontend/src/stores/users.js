import { defineStore } from "pinia"
import axios from 'axios'
import config from '@config'

export const useUsersStore = defineStore('users', {
    state: () => ({
        users: [],
    }),
    actions: {
        async fetchUsers(user) {
            try {
                const response = await axios.get(`${config.apiUrl}/users`)

                this.users = response.data
            } catch (error) {
                console.error(error)
            }
        }
    }
})