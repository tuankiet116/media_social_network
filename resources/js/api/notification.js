import api from './baseAPI';

export const getNotifications = (offset) => api.get(`/api/notification/list?offset=${offset}`);
export const countUnreadNotifications = () => api.get(`/api/notification/count-unread`);
export const markRead = (idNotification) => api.post(`/api/notification/mark-read/${idNotification}`);
export const markReadAll = () => api.post(`/api/notification/mark-read-all`);
