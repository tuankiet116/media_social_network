import api from './baseAPI';

export const createCommunityAPI = (data) => api.post('api/community/create', data);