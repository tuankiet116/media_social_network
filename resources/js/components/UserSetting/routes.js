import SettingInformation from './SettingInformation.vue';
import SettingAvatar from './SettingAvatar.vue';
import SettingBackground from './SettingBackground.vue';
import SettingPassword from './SettingPassword.vue';

import { detectUser } from '../../api/auth';

const userSetting = [
    { path: 'basic', component: SettingInformation, name: "edit_profile_basic", beforeEnter: checkAuth, props: true },
    { path: 'avatar', component: SettingAvatar, name: "edit_profile_avatar", beforeEnter: checkAuth, props: true },
    { path: 'background', component: SettingBackground, name: "edit_profile_background", beforeEnter: checkAuth, props: true },
    { path: 'password', component: SettingPassword, name: "edit_profile_password", beforeEnter: checkAuth, props: true },
];

async function checkAuth(to, from, next) {
    let user = await detectUser().then(result => result.data).catch(error => {});
    if (user) {
        next();
    } else {
        window.location.href = '/user/login';
    }
}

export default userSetting;