// services/authService.ts
import type { User, LoginCredentials } from '@/types/user'
import axios from 'axios'

interface AuthResponse {
  user: User;
  token: string;
}

const api = axios.create({
    baseURL: 'http://localhost:8000/api/v1',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})

export const authService = {
    async login(credentials: LoginCredentials): Promise<AuthResponse> {
        try {
            const response = await api.post('/login', credentials)
            return response.data
        } catch (error) {
            console.error('API Error:', error)
            throw error
        }
    }
}