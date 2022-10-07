import axios from "axios";

export const detectUser = () => axios.get(`api/user`);