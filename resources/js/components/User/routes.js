import UserPostComponent from './UserPostComponent.vue';
import FollowersComponent from './FollowersComponent.vue';
import { detectUser } from '../../api/auth';

const userRouters = [
    { path: ':id?', component: UserPostComponent, name: "list_post", beforeEnter: checkUserId },
    { path: ':id?/followers', component: FollowersComponent, name: "list_followers", beforeEnter: checkUserId },
    { path: 'followers', component: FollowersComponent, name: "list_followers", beforeEnter: checkAuth }
];

async function checkUserId(to, from, next) {
    let user = await detectUser().then(result => result.data).catch(error => {});
    if (parseInt(to.params.id) || user) {
        next();
    } else {
        window.location.href = '/user/login';
    }
}

async function checkAuth(to, from, next) {
    let user = await detectUser().then(result => result.data).catch(error => {});
    if (user) {
        next();
    } else {
        window.location.href = '/user/login';
    }
}

export default userRouters;