<template>
    <div v-if="userCall" id="modal-js" class="modal" :class="{ 'is-active': userCall }">
        <div class="modal-background" @click="closeModal"></div>

        <div class="modal-content">
            <div class="box">
                <p>{{ userCall.name }} đang gọi cho bạn</p>
                <div class="buttons is-justify-content-center">
                    <button class="button is-primary" @click="acceptCall">Chấp nhận</button>
                    <button class="button is-danger" @click="declineCall">Từ chối</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { accept, decline } from '../../api/video';
export default {
    data() {
        return {};
    },
    props: ['userCall'],
    methods: {
        acceptCall() {

        },
        declineCall() {

        }
    }
}
</script>