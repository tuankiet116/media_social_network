import BasicInformation from './BasicInformation.vue';
import CommunityAvatar from './CommunityAvatar.vue';
import CommunityBackground from './CommunityBackground.vue';
import CommunityMember from './CommunityMember.vue';
import DeleteCommunity from './DeleteCommunity.vue';
import { detectUser } from '../../api/auth';

const communitySettingRouters = [
    { path: '', component: BasicInformation, name: "community_setting_basic", beforeEnter: checkAuth },
    { path: 'avatar', component: CommunityAvatar, name: "community_setting_avatar", beforeEnter: checkAuth },
    { path: 'background', component: CommunityBackground, name: "community_setting_background", beforeEnter: checkAuth },
    { path: 'members', component: CommunityMember, name: "community_setting_member", beforeEnter: checkAuth },
    { path: 'delete', component: DeleteCommunity, name: "community_setting_delete", beforeEnter: checkAuth }
];

async function checkAuth(to, from, next) {
    let user = await detectUser().then(result => result.data).catch(error => { });
    if (user) {
        next();
    } else {
        window.sessionStorage.removeItem('user');
        window.location.href = '/user/login';
    }
}

export default communitySettingRouters;