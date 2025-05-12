import http from '@/services/http.js'
import { useAuthStore } from '@/stores/auth.js'

class ApiService {
    constructor() {
        const authStore = useAuthStore()
        this.token = authStore.token
    }

    async get(url) {
        const response = await http.get(url, {
            headers: {
                Authorization: `Bearer ${this.token}`
            }
        })
        return response
    }

    async post(url, data) {
        const response = await http.post(url, data, {
            headers: {
                Authorization: `Bearer ${this.token}`
            }
        })
        return response
    }

    async put(url, data) {
        const response = await http.puts(url, data, {
            headers: {
                Authorization: `Bearer ${this.token}`
            }
        })
        return response
    }

    async delete(url, data) {
        const response = await http.delete(url, data, {
            headers: {
                Authorization: `Bearer ${this.token}`
            }
        })
        return response
    }

    async postMidia(url, data) {
        const response = await http.post(url, data, {
            headers: {
                Authorization: `Bearer ${this.token}`,
                'Content-Type': 'multipart/form-data',
            }
        })
        return response
    }
}

export default new ApiService()