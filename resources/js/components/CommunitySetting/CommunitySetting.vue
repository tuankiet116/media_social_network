<template>
    <div v-if="!isNotfound" id="setting" class="container mt-5">
        <div class="content">
            <h2><span><i class="fa-solid fa-gear"></i> Setting Community {{ community?.community_name }}</span></h2>
        </div>
        <div class="box columns">
            <div class="column is-2 is-flex-tablet">
                <aside class="menu">
                    <p class="menu-label">
                        General
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link :to="{ name: 'community_setting_basic' }"
                                :class="{ 'is-active': $route.name == 'community_setting_basic' }">
                                Basic Information
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'community_setting_avatar' }"
                                :class="{ 'is-active': $route.name == 'community_setting_avatar' }">
                                Avatar
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'community_setting_background' }"
                                :class="{ 'is-active': $route.name == 'community_setting_background' }">
                                Background
                            </router-link>
                        </li>
                    </ul>
                    <p class="menu-label">
                        Member
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link :to="{ name: 'community_setting_member' }"
                                :class="{ 'is-active': $route.name == 'community_setting_member' }">
                                List Member
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'edit_profile_password' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_password' }">
                                Banned Member
                            </router-link>
                        </li>
                    </ul>
                </aside>
            </div>
            <div class="column">
                <router-view :community="community" @updated="updateCommunity"></router-view>
            </div>
        </div>
    </div>
    <div v-else>
        <not-found-component />
    </div>
</template>
<script>
import { getCommunityAPI } from '../../api/community';
import authMixin from '../../mixins';
import NotFoundComponent from '../Common/errors/NotFoundComponent.vue';
import { useToast } from 'vue-toastification';
export default {
    components: { NotFoundComponent },
    data() {
        return {
            community: null,
            isNotfound: false
        };
    },
    mixins: [authMixin],
    mounted() {
        this.getcommunityInformation();
    },
    methods: {
        getcommunityInformation() {
            let communityId = this.$route.params.id;
            getCommunityAPI(communityId).then(result => {
                this.community = result.data;
                if (this.community.user_id != this.$store.state.user.id) {
                    this.$router.go(1);
                }
            }).catch(error => {
                if (error.response.status == 404) {
                    this.isNotfound = true;
                }
            })
        },
        updateCommunity(data) {
            this.community = data;
            useToast().success('Your Community Updated');
        }
    },
}
</script>