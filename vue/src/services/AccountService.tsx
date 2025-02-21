import request from '@/utils/request'

class AccountService {
    async getDetailAccount(id: number, data: object): Promise<any> {
        return request.get(`/detail-account/${id}`, data );
    }

    async createAccount(data: object): Promise<any> {
        return request.post(`/create-account`, data, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
        });
    }

    async updateAccount(id: number, data: object): Promise<any> {
        return request.post(`/update-account/${id}`, data, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
        });
    }

    async deleteAccount(id: number): Promise<any> {
        return request.delete(`/delete-account/${id}`)
    }

    async listAccount(filters = {}, page = 1, perPage = 10) {
        const params = new URLSearchParams({
            page,
            per_page: perPage,
            search: filters.search || '',
            role: filters.role || '',
            sort_field: filters.sort_field || 'created_at',
            sort_order: filters.sort_order || 'desc'
        });
        
        return request.get(`/list-account?${params.toString()}`);
    }
}

export default new AccountService()
