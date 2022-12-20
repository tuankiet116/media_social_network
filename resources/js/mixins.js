import { detectUser } from "./api/auth";
const authMixin = {
    beforeCreate() {
        detectUser().then(result => {
            sessionStorage.setItem("user", JSON.stringify(result.data));
            this.$store.commit('getUserInformation', result.data);
        }).catch(err => {
            sessionStorage.removeItem("user");
            this.$store.commit('getUserInformation', null);
        });
    }
}

export default authMixin;