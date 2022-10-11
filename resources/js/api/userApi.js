import axios from "axios";

export const detectUser = () => axios.get(`api/user`);
export const logoutUser = () => axios.post('api/logout');