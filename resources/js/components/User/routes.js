import UserPostComponent from './UserPostComponent.vue';
import { detectUser } from '../../api/api';

const userRouters = [
    { path: '', component: UserPostComponent, name: "list_post", beforeEnter: checkUserId }
];

async function checkUserId(to, from, next) {
    let user = await detectUser().then(result => result.data).catch(error => {});
    if (parseInt(to.params.id) || user) {
        next();
    }
    window.location.href = '/user/login';
}

async function checkAuth() {
    let user = await detectUser().then(result => result.data).catch(error => {});
    if (user) {
        next();
    }
    window.location.href = '/user/login';
}

export default userRouters;