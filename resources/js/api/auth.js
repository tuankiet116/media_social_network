import api from './baseAPI';

export const detectUser = () => api.get(`api/user`);
export const logoutUser = () => api.post('api/logout');