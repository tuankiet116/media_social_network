import CreatePostComponent from './components/Post/CreatePostComponent';
import DashboardComponent from './components/DashboardComponent';
import EditPostComponent from './components/Post/EditPostComponent';
import DetailPostComponent from './components/Post/DetailPostComponent.vue';
import UserPageComponent from './components/User/UserPageComponent.vue';
import userRouters from './components/User/routes';

const routes = [
    { path: '/', component: DashboardComponent, name: 'home' },
    { path: '/post/create', component: CreatePostComponent, name: 'create_post' },
    { path: '/post/edit/:id', component: EditPostComponent, name: 'edit_post' },
    { path: '/post/:id', component: DetailPostComponent, name: 'post_detail' },
    { path: '/profile/:id?', children: userRouters, component: UserPageComponent, name: 'user_profile' }
];

export default routes