<template>
    <div v-if="!isNotfound" id="setting" class="container mt-5">
        <div class="content">
            <h2><span><i class="fa-solid fa-gear"></i> {{ $t('community_setting.setting') }} {{ community?.community_name }}</span></h2>
        </div>
        <div class="box columns">
            <div class="column is-2 is-flex-tablet">
                <aside class="menu">
                    <p class="menu-label">
                        {{ $t('community_setting.general') }}
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link :to="{ name: 'community_setting_basic' }"
                                :class="{ 'is-active': $route.name == 'community_setting_basic' }">
                                {{ $t('community_setting.basic') }}
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'community_setting_avatar' }"
                                :class="{ 'is-active': $route.name == 'community_setting_avatar' }">
                                {{ $t('community_setting.avatar_setting') }}
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'community_setting_background' }"
                                :class="{ 'is-active': $route.name == 'community_setting_background' }">
                                {{ $t('community_setting.background_setting') }}
                            </router-link>
                        </li>
                    </ul>
                    <p class="menu-label">
                        {{ $t('community_setting.member_setting') }}
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link :to="{ name: 'community_setting_member' }"
                                :class="{ 'is-active': $route.name == 'community_setting_member' }">
                                {{ $t('community_setting.list_member') }}
                            </router-link>
                        </li>
                        <li>
                            <router-link class="is-danger" :to="{ name: 'community_setting_delete' }"
                                :class="{ 'is-active': $route.name == 'community_setting_delete' }">
                                {{ $t('community_setting.delete') }}
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
            useToast().success(this.$t('community_setting.updated'));
        }
    },
}
</script>