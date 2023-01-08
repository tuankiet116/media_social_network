import BasicInformation from './BasicInformation.vue';
import CommunityAvatar from './CommunityAvatar.vue';
import CommunityBackground from './CommunityBackground.vue';

const communitySettingRouters = [
    { path: '', component: BasicInformation, name: "community_setting_basic" },
    { path: 'avatar', component: CommunityAvatar, name: "community_setting_avatar" },
    { path: 'background', component: CommunityBackground, name: "community_setting_background" }
];

export default communitySettingRouters;