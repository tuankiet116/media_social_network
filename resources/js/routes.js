import CreatePostComponent from './components/Post/CreatePostComponent';
import DashboardComponent from './components/DashboardComponent';
import EditPostComponent from './components/Post/EditPostComponent';
import DetailPostComponent from './components/Post/DetailPostComponent.vue';
import UserPageComponent from './components/User/UserPageComponent.vue';
import UserSettingComponent from './components/UserSetting/UserSettingComponent.vue';
import userRouters from './components/User/routes';
import userSetting from './components/UserSetting/routes';
import communityRouters from './components/Community/routes';

const routes = [
    { path: '/', component: DashboardComponent, name: 'home' },
    { path: '/post/create', component: CreatePostComponent, name: 'create_post' },
    { path: '/post/edit/:id', component: EditPostComponent, name: 'edit_post' },
    { path: '/post/:id', component: DetailPostComponent, name: 'post_detail' },
    { path: '/profile', children: userRouters, component: UserPageComponent, name: 'user_profile' },
    { path: '/setting', component: UserSettingComponent, children: userSetting, name: 'user_setting', props: true },
    { path: '/community', children: communityRouters }
];

export default routes