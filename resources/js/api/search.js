import api from './baseAPI';

export const searchHistory = (keyword) => api.get(`/api/search/history?keyword=${keyword}`);
export const searchAll = (keyword) => api.get(`/api/search/all?keyword=${keyword}`);
export const searchUser = (keyword) => api.get(`/api/search/user?keyword=${keyword}`);
export const searchPost = (keyword) => api.get(`/api/search/post?keyword=${keyword}`);
export const searchCommunity = (keyword) => api.get(`/api/search/community?keyword=${keyword}`);
