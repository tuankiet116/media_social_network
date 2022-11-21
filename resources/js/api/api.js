import axios from "axios";
const host = window.location.origin;
const api = axios.create({
    baseURL: host,
});

export const detectUser = () => api.get(`api/user`);
export const logoutUser = () => api.post('api/logout');

export const createPost = function (data, config) {
    return api.post('api/post/create', data, config)
};
export const getPosts = (data) => api.get('api/post/list', data);
export const getPost = (postID) => api.get(`api/post/get/${postID}`);
export const deletePost = (postID) => api.delete(`api/post/delete/${postID}`);
export const reactPostAPI = (data) => api.post('api/post/reaction', data);
export const updatePost = (data) => api.put('api/post/update', data);

export const createComment = (data) => api.post('api/comment/create', data);
export const getListCommentAPI = (postID, offset) => api.get(`api/comment/list/${postID}/${offset}`);
export const deleteCommentAPI = (commentId) => api.delete(`api/comment/delete/${commentId}`);
export const likeCommentAPI = (data) => api.post('api/comment/like', data);
