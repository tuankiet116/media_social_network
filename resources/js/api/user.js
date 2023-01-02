import api from './baseAPI';

export const getProfile = () => api.get(`api/profile/me`);
export const getUserProfile = (id) => api.get(`api/profile/${id}`);
export const updateUserProfile = (data) => api.put('api/profile/update/info', data);