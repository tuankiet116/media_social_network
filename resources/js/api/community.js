import api from './baseAPI';

export const createCommunityAPI = (data) => api.post('api/community/create', data);
export const getCommunityAPI = (id) => api.get('api/community/info/' + id);
export const getCommunityPostsAPI = (id, offset) => api.get('api/community/posts/' + id + '/' + offset);
export const getCommunitiesAPI = (data) => api.get('api/community/list', {
    params: data
});