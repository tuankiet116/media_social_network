import { detectUser } from "../api/userApi"

export default {
    getUserInformation(state) {
        detectUser().then(result => {
            state.user = result.data;
        }).catch(err => {
            state.user = null;
        });
    }
}