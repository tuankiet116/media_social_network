import api from './baseAPI';

export const createCommunityAPI = (data) => api.post('api/community/create', data);
export const getCommunityAPI = (id) => api.get('api/community/info/' + id);
export const getCommunityPostsAPI = (id, offset) => api.get('api/community/posts/' + id + '/' + offset);
export const getCommunitiesAPI = (data) => api.get('api/community/list', {
    params: data
});

export const updateCommunityInfo = (data, id) => api.post(`api/community/setting/info/${id}`, data);
export const updateCommunityAvatar = (data, id) => api.post(`api/community/setting/avatar/${id}`, data);
export const updateCommunityBackground = (data, id) => api.post(`api/community/setting/background/${id}`, data);