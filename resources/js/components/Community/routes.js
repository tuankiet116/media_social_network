import { detectUser } from '../../api/auth';
// import communitySettingRouters from './CommunitySetting/routes';
import CommunityPage from './CommunityPage.vue';

const groupRouters = [
    { path: ':id', component: CommunityPage, name: "community_page", beforeEnter: checkAuth },
    // { path: '/:id/setting', component: CommunityPage, children: communitySettingRouters, beforeEnter: checkAuth }
];

async function checkAuth(to, from, next) {
    let user = await detectUser().then(result => result.data).catch(error => {});
    if (user) {
        next();
    } else {
        window.location.href = '/user/login';
    }
}

export default groupRouters;