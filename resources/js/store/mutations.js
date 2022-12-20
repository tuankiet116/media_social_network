import * as API from "../api/auth"

export default {
    getUserInformation(state, payload) {
        state.user = payload;
    },
    logoutUser(state) {
        API.logoutUser().then(result => {
            state.user = null;
        }).catch(err => {
            console.log(err);
        });
    },
    updateProgressUpload(state, payload) {
        state.updateProgressUpload = payload;
    }
}