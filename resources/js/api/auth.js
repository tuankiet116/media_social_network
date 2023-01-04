import api from './baseAPI';

export const detectUser = () => api.get(`api/user`);
export const logoutUser = () => api.post('api/logout');
export const updatePassword = (data) => api.post('api/user/password', data);