// vue/src/services/System/HistoryService.tsx
import request from '@/utils/request'

class HistoryService {
    async getHistory(filters = {}) {
        const params = new URLSearchParams({
            page: filters.page?.toString() || '1',
            per_page: filters.per_page?.toString() || '10',
            module: filters.module || '',
            action: filters.action || '',
            date_from: filters.dateFrom || '',
            date_to: filters.dateTo || '',
            search: filters.search || ''
        });
        
        return request.get(`/history?${params.toString()}`);
    }
}
export default new HistoryService()