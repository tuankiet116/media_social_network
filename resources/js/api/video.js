import api from './baseAPI';

export const callUser = (data) => api.post(`/api/video/call-user`, data);
export const accept = (data) => api.post(`/api/video/accept`, data);
export const decline = (data) => api.post(`/api/video/decline`, data);

