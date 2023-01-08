import api from './baseAPI';

export const getProfile = () => api.get(`api/profile/me`);
export const getUserProfile = (id) => api.get(`api/profile/info/${id}`);
export const updateUserProfile = (data) => api.put('api/profile/update/info', data);
export const listDefaultAvatar = () => api.get('api/profile/default/avatar');
export const listDefaultBackground = () => api.get('api/profile/default/background');
export const saveUserImage = (data) => api.post('api/profile/update/avatar', data);
export const saveUserBackground = (data) => api.post('api/profile/update/background', data, { "Contect-type": "multipart/form-data" });

export const followUser = (data) => api.post('api/profile/follow', data);
export const unfollowUser = (data) => api.post('api/profile/unfollow', data);
export const getFollower = (userId, offset) => api.get(`api/profile/follower?userId=${userId}&offset=${offset}`);
export const getFollowing = (userId, offset) => api.get(`api/profile/following?userId=${userId}&offset=${offset}`);