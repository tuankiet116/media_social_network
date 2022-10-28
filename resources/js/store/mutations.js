import * as API from "../api/api"

export default {
    getUserInformation(state) {
        API.detectUser().then(result => {
            state.user = result.data;
        }).catch(err => {
            state.user = null;
        });
    },
    logoutUser(state) {
        API.logoutUser().then(result => {
            state.user = null;
        }).catch(err => {
            console.log(err);
        });
    }
}