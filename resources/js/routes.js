import CreatePostComponent from './components/Post/CreatePostComponent';
import DashboardComponent from './components/DashboardComponent';
import EditPostComponent from './components/Post/EditPostComponent';
import DetailPostComponent from './components/Post/DetailPostComponent.vue';
import UserPageComponent from './components/User/UserPageComponent.vue';
import UserSettingComponent from './components/UserSetting/UserSettingComponent.vue';
import CommunityPage from './components/Community/CommunityPage.vue';
import CommunitySetting from './components/CommunitySetting/CommunitySetting.vue';
import SearchResultComponent from './components/Search/SearchResultComponent'

import userRouters from './components/User/routes';
import userSetting from './components/UserSetting/routes';
import communityRouters from './components/Community/routes';
import communitySettingRouters from './components/CommunitySetting/routes';
import { detectUser } from './api/auth';

const routes = [
    {
        path: '/',
        component: DashboardComponent,
        name: 'home'
    },
    {
        path: '/post/create',
        component: CreatePostComponent,
        name: 'create_post',
        beforeEnter: checkAuth
    },
    {
        path: '/post/edit/:id',
        component: EditPostComponent,
        name: 'edit_post',
        beforeEnter: checkAuth
    },
    {
        path: '/post/:id',
        component: DetailPostComponent,
        name: 'post_detail'
    },
    {
        path: '/profile/:id',
        children: userRouters,
        component: UserPageComponent,
        name: 'user_profile',
        props: true
    },
    {
        path: '/setting',
        component: UserSettingComponent,
        children: userSetting,
        name: 'user_setting',
        props: true
    },
    {
        path: '/community',
        component: CommunityPage,
        children: communityRouters
    },
    {
        path: '/community-setting/:id',
        component: CommunitySetting,
        children: communitySettingRouters,
        name: 'community_setting',
        beforeEnter: [checkAuth, checkIsMine]
    },
    {
        path: '/search',
        component: SearchResultComponent,
        name: 'search_page'
    }
];

async function checkAuth(to, from, next) {
    let user = await detectUser().then(result => result.data).catch(error => { });
    if (user) {
        next();
    } else {
        window.location.href = '/user/login';
    }
}

async function checkIsMine(to, from, next) {
    next();
}

export default routes