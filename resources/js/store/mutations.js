import * as UserAPI from "../api/userApi"

export default {
    getUserInformation(state) {
        UserAPI.detectUser().then(result => {
            state.user = result.data;
        }).catch(err => {
            state.user = null;
        });
    },
    logoutUser(state) {
        UserAPI.logoutUser().then(result => {
            state.user = null;
        }).catch(err => {
            console.log(err);
        });
    }
}