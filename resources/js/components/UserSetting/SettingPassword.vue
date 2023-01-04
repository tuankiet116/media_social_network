<template>
    <div>
        <div class="field">
            <label>Old Password: </label>
            <input type="password" name="old_password" v-model="oldPassword" class="input"/>
        </div>
        <hr/>
        <div class="field">
            <label>New Password: </label>
            <input type="password" name="new_password" v-model="newPassword" class="input"/>
        </div>
        <div class="field">
            <label>Confirm Password: </label>
            <input type="password" name="confirm_password" v-model="confirmPassword" class="input"/>
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
export default {
    data() {
        return {
            newPassword: null,
            oldPassword: null,
            confirmPassword: null
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
            
        }
    }
}
</script>
<style scoped>
</style>