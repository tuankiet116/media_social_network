import { detectUser } from '../../api/auth';
import communitySettingRouters from './CommunitySetting/routes';
import CommunityPost from './CommunityPost.vue';

const groupRouters = [
    { path: ':id', component: CommunityPost, name: "community_page" },
    { path: '/:id/setting', component: CommunityPost, children: communitySettingRouters, beforeEnter: checkAuth }
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