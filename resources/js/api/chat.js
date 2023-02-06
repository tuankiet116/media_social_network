import api from './baseAPI';

export const sendMessage = (data) => api.post(`/api/message/send`, data);
export const markReadChat = (data) => api.post(`api/message/mark-read`, data);
export const listChat = (offset) => api.get(`/api/message/list-chat?offset=${offset}`);
export const getMessages = (id, offset) => api.get(`/api/message/chat/${id}?offset=${offset}`);
export const getUnreadChat = () => api.get(`/api/message/unread-chat`);

export const callUser = () => api.post(`/api/video/call-user`, data);
