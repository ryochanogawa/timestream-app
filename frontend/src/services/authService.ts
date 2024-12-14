// services/authService.ts
import type { User, LoginCredentials, RegisterCredentials } from '@/types/user'
import axios from 'axios'

interface AuthResponse {
    user: {
        id: number;
        name: string;
        email: string;
    }
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

            //レスポンスデータの整形
            const user = response.data.user.original.user;
            const token = response.data.user.original.token;
            return { user, token };
        } catch (error) {
            console.error('API Error:', error)
            throw error
        }
    },
    async register(credentials: RegisterCredentials): Promise<AuthResponse> {
        try {
            const response = await api.post('/register', credentials)
            return response.data
        } catch (error) {
            console.error('API Error:', error)
            throw error
        }
    }
}