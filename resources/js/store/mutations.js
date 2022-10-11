import { detectUser } from "../api/userApi"

export default {
    getUserInformation(state) {
        detectUser().then(data => {
            state.user = data;
        }).catch(err => {
            state.user = null;
        });
    }
}