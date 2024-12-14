// services/userService.ts
import type { User } from '@/types/user'
import { useContext } from '@nuxtjs/composition-api'

export const userService = {
    getUser: async (): Promise<User> => {
        const { $axios } = useContext()
        const response = await $axios.get('/user')
        if(response.data.status === 200) {
            return response.data.user
        }else{
            throw new Error('ユーザー情報の取得に失敗しました')
        }
    }
}
