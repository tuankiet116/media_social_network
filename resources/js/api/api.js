import axios from "axios";

export const detectUser = () => axios.get(`api/user`);
export const logoutUser = () => axios.post('api/logout');
export const createPost = (data, config) => axios.post('api/post/create', data, config);
export const getPosts = (data) => axios.get('api/post/list', data);