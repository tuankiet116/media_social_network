import BasicInformation from './BasicInformation.vue';
import CommunityAvatar from './CommunityAvatar.vue';
import CommunityBackground from './CommunityBackground.vue';
import CommunityMember from './CommunityMember.vue';
import DeleteCommunity from './DeleteCommunity.vue';

const communitySettingRouters = [
    { path: '', component: BasicInformation, name: "community_setting_basic" },
    { path: 'avatar', component: CommunityAvatar, name: "community_setting_avatar" },
    { path: 'background', component: CommunityBackground, name: "community_setting_background" },
    { path: 'members', component: CommunityMember, name: "community_setting_member" },
    { path: 'delete', component: DeleteCommunity, name: "community_setting_delete" }
];

export default communitySettingRouters;