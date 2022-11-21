import CreatePostComponent from './components/Post/CreatePostComponent';
import DashboardComponent from './components/DashboardComponent';
import EditPostComponent from './components/Post/EditPostComponent';
import DetailPostComponent from './components/Post/DetailPostComponent.vue';

const routes = [
    { path: '/', component: DashboardComponent, name: 'home', reload: true },
    { path: '/post/create', component: CreatePostComponent, name: 'create_post' },
    { path: '/post/edit/:id', component: EditPostComponent, name: 'edit_post' },
    { path: '/post/:id', component: DetailPostComponent, name: 'post_detail' },
];

export default routes