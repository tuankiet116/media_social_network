import api from './baseAPI';

export const searchHistory = (keyword) => api.get(`/api/search/history?keyword=${keyword}`);
export const searchAll = (keyword) => api.get(`/api/search/all?keyword=${keyword}`);
