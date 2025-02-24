import request from '@/utils/request'

class FlashcardService {
    async translateText(data: object): Promise<any> {
        return request.post(`/translate`, data);
    }

    async checkUsage(): Promise<any> {
        return request.get(`/check-usage`);
    }
}

export default new FlashcardService();


