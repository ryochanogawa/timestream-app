// composables/useAuth.ts
import { ref, useContext, onMounted } from '@nuxtjs/composition-api'
import type { User, LoginCredentials, RegisterCredentials } from '~/types/user'
import { authService } from '~/services/authService'
import { userService } from '~/services/userService'

interface AuthResponse {
    user: User;
    token: string;
}
   
   export const useAuth = () => {
      const user = ref<User | null>(null)
      const isAuthenticated = ref<boolean>(false)
      let token: string | null = null
   
      const initAuth = async () => {
          if (process.client) {
              const token = localStorage.getItem('token')
              isAuthenticated.value = !!(token && token !== 'undefined')
              if (isAuthenticated.value) {
                user.value = await userService.getUser()
              }
              return isAuthenticated.value
          }
          return false
      }
   
      const setToken = (newToken: string) => {
          if (process.client) {
              token = newToken
              try {
                  window.localStorage.setItem('token', newToken)
                  isAuthenticated.value = true
              } catch (e) {
                  console.error('localStorage error:', e)
              }
          }
      }
   
      const getToken = (): string | null => {
          if (process.client) {
              try {
                  return window.localStorage.getItem('token')
              } catch (e) {
                  console.error('localStorage error:', e)
                  return null
              }
          }
          return token
      }
   
      const removeToken = () => {
          if (process.client) {
              token = null
              isAuthenticated.value = false
              try {
                  window.localStorage.removeItem('token')
              } catch (e) {
                  console.error('localStorage error:', e)
              }
          }
      }
   
      const login = async (credentials: LoginCredentials) => {
            try {
                const response: AuthResponse = await authService.login(credentials)
                if (response && response.token) {
                    setToken(response.token)
                    user.value = response.user
                    return true
                }
                throw new Error('認証に失敗しました')
            } catch (error) {
                console.error('ログインエラー:', error)
                throw error
            }
        }

        const logout = async () => {
            try {
                user.value = null
                removeToken()
                return true
            } catch (error) {
                console.error('ログアウトに失敗しました:', error)
                throw error
            }
        }
  
        const register = async (credentials: RegisterCredentials) => {
          try {
              const registerResponse = await authService.register(credentials);  
          } catch (error) {
              console.error('新規登録エラー:', error)
              throw error
          }
        }
   
      return {
          user,
          isAuthenticated,
          login,
          logout,
          register,
          initAuth,
          getToken,
          setToken,
          removeToken
      }
   }