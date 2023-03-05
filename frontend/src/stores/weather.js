import { defineStore } from "pinia"
import axios from 'axios'

export const useWeatherStore = defineStore('weather', {
    state: () => ({
        users: [],
    }),
    actions: {
        async fetchWeather(user) {
            try {
                const response = await axios.get(`/api/weather/`)
                const weather = response.data

                user.weather = {
                    temperature: 123,
                    condition: 321
                }
            } catch (error) {
                console.error(error)
            }
        },
        async fetchAllWeather(users) {
            await Promise.all(users.map(user => this.fetchWeather(user)))
        }
    }
})