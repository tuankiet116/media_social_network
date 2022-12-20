import api from './baseAPI';

export const createPost = function (data, config) {
    return api.post('api/post/create', data, config)
};
export const getPosts = (offset) => api.get(`api/post/list/${offset}`);
export const getPostsByUser = (offset, userId) => api.get(`api/post/list/${offset}/${userId}`);
export const getPost = (postID) => api.get(`api/post/get/${postID}`);
export const deletePost = (postID) => api.delete(`api/post/delete/${postID}`);
export const reactPostAPI = (data) => api.post('api/post/reaction', data);
export const updatePost = (data) => api.put('api/post/update', data);

export const createComment = (data) => api.post('api/comment/create', data);
export const getListCommentAPI = (postID, offset) => api.get(`api/comment/list/${postID}/${offset}`);
export const deleteCommentAPI = (commentId) => api.delete(`api/comment/delete/${commentId}`);
export const likeCommentAPI = (data) => api.post('api/comment/like', data);
export const updateCommentAPI = (data) => api.put('api/comment/update', data);
export const replyCommentAPI = (data) => api.post('api/comment/reply', data);
export const getRepliesCommentsAPI = (commentId, offset) => api.get(`api/comment/list/${commentId}/reply/${offset}`);