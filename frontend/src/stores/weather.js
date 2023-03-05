import { defineStore } from "pinia"
import axios from 'axios'
import config from '@config'

export const useWeatherStore = defineStore('weather', {
    state: () => ({
        weather: {},
        isLoading: true,
    }),
    actions: {
        async fetchWeather(userId) {
            try {
                const response = await axios.get(`${config.apiUrl}/weather/${userId}`)

                this.weather = response.data

                this.isLoading = false
            } catch (error) {
                console.error(error)
            }
        }
    }
})