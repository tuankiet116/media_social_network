import axios from "axios";

export const detectUser = () => axios.get(`api/user`);
export const logoutUser = () => axios.post('api/logout');
export const createPost = function (data, config) {
    return axios.post('api/post/create', data, config)
};
export const getPosts = (data) => axios.get('api/post/list', data);
export const getPost = (postID) => axios.get(`api/post/get/${postID}`);
export const reactPostAPI = function (data) {
    return axios.post('api/post/reaction', data);
}

export const createComment = (data) => axios.post('api/comment/create', data);
export const getListCommentAPI = (postID, offset) => axios.get(`api/comment/list/${postID}/${offset}`);
export const deleteCommentAPI = (commentId) => axios.delete(`api/comment/delete/${commentId}`);
