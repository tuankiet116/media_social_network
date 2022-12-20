import axios from "axios";
const host = window.location.origin;
const api = axios.create({
    baseURL: host,
});
export default api;