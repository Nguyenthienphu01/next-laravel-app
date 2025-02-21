import request from '@/utils/request'

class AuthService {
    login(data: object): Promise<any> {
        return request.post('/login', data)
    }

    logout(): Promise<any> {
        return request.post('/auth/logout')
    }

    changePassword(data: object): Promise<any> {
        return request.patch('/auth/change-password', data)
    }
}

export default new AuthService()
