import CreatePostComponent from './components/CreatePostComponent';
import DashboardComponent from './components/DashboardComponent';

const routes = [
    { path: '/', component: DashboardComponent, name: 'home' , reload: true},
    { path: '/create-post', component: CreatePostComponent, name: 'create_post' },
];

export default routes