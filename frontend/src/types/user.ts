// frontend/src/types/user.ts

export interface User {
    id: number
    name: string
    email: string
}

export interface LoginCredentials {
    email: string
    password: string
}

export interface RegisterCredentials {
    name: string
    email: string
    password: string
}