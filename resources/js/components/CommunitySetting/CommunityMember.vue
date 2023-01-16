<template>
    <div v-if="auth" class="box container" :style="{ 'min-height: unset': !members.length }">
        <div v-if="members.length" class="columns" v-for="i in Math.ceil(members.length / 2)">
            <div class="column is-half" v-for="(member, index) in members.slice((i - 1) * 2, i * 2)">
                <div class="is-flex">
                    <div class="user_image" @mouseover="displayUserInformation = true">
                        <router-link :to="{ name: 'profile_list_post', params: { id: member.user.id } }">
                            <figure class="image is-64x64 avatar-image">
                                <img class="is-rounded" :src="member.user.image" />
                            </figure>
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <UserInforCard v-if="displayUserInformation" :user="member.user" />
                            </KeepAlive>
                        </div>
                    </div>
                    <div class="is-justify-content-left ml-2 user_name">
                        <router-link :to="{ name: 'profile_list_post', params: { id: member.user.id } }">
                            {{ member.user.name }}
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <UserInforCard v-if="displayUserInformation" :user="member.user" />
                            </KeepAlive>
                        </div>
                    </div>
                    <div style="margin-left:auto" class="is-flex is-align-items-center">
                        <button v-if="community.id != member.user.id" class="button"
                            @click="removeMember(member.user.id)">
                            Delete Member {{ i+index }}
                        </button>
                        <p v-else class="content p-2" style="background-color:blanchedalmond">
                            Administrator {{ i+index }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class=" has-text-centered">
            <p class="content is-size-4">No members At All.</p>
            <figure>
                <img src="../../../images/gifs/sad_stitch.gif" />
            </figure>
        </div>
    </div>
</template>
<script>
import { listMembers, deleteMember } from '../../api/community';
import UserInforCard from '../Common/UserInforCard.vue';
import authMixin from '../../mixins';
export default {
    props: ['community'],
    components: { UserInforCard },
    data() {
        return {
            members: [],
            offset: 0,
            displayUserInformation: false
        };
    },
    mounted() {
        this.getMembers();
    },
    watch: {
        community(data) {
            this.getMembers();
        }
    },
    mixins: [authMixin],
    methods: {
        getMembers() {
            if (!this.community) return;
            listMembers(this.community.id, this.offset).then(result => {
                this.members = result.data.members;
                this.offset = result.data.offset;
            });
        },
        async removeMember(userId, idx) {
            debugger
            await deleteMember(this.community.id, userId).then(result => {
                if (result.data == true) {
                    let indexMember = this.members.findIndex(el => el.user.id == userId);
                    this.members.splice(indexMember, 1);
                }
            });
        }
    }
}
</script>
<style scoped>
.container {
    min-height: 20rem;
}

.user-card {
    position: absolute;
    z-index: 10;
    width: 300px;
    display: none;
    top: 5rem;
}

.user_image {
    position: relative;
}

.user_name {
    display: flex;
    align-items: center;
    position: relative;
}

.user_name:hover .user-card {
    display: block;
    transform: translate(0, -20px);
    transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}

.user_image:hover .user-card {
    display: block;
    transform: translate(0, -20px);
    transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}
</style>