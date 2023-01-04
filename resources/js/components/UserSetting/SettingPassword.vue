<template>
    <div>
        <div class="field">
            <label>Old Password: </label>
            <input
                type="password"
                name="old_password"
                v-model="oldPassword"
                class="input"
            />
            <p v-if="errors.old_password" class="has-text-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span v-for="error in errors.old_password">{{
                    error
                }}</span>
            </p>
        </div>
        <hr />
        <div class="field">
            <label>New Password: </label>
            <input
                type="password"
                name="new_password"
                v-model="newPassword"
                class="input"
            />
            <p v-if="errors.new_password" class="has-text-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span v-for="error in errors.new_password">{{
                    error
                }}</span>
            </p>
        </div>
        <div class="field">
            <label>Confirm Password: </label>
            <input
                type="password"
                name="confirm_password"
                v-model="confirmPassword"
                class="input"
            />
            <p v-if="errors.confirm_password" class="has-text-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span v-for="error in errors.confirm_password">{{
                    error
                }}</span>
            </p>
        </div>
        <div class="field is-grouped mt-3 columns is-justify-content-end">
            <button
                @click="updatePassword"
                class="button is-info is-1-desktop is-full-mobile"
            >
                Save
            </button>
        </div>
    </div>
</template>
<script>
import { useToast } from "vue-toastification";
import { updatePassword } from "../../api/auth";
export default {
    data() {
        return {
            newPassword: null,
            oldPassword: null,
            confirmPassword: null,
            errors: {},
        };
    },
    methods: {
        validate() {
            if (this.newPassword === this.confirmPassword) {
                return true;
            }
            return false;
        },
        updatePassword() {
            let data = {
                old_password: this.oldPassword,
                new_password: this.newPassword,
                confirm_password: this.confirmPassword,
            };
            updatePassword(data)
                .then((result) => {
                    useToast().success('Your password has been updated');
                    this.errors = {};
                    this.$router.push({path: '/profile'});
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
    },
};
</script>
<style scoped></style>
