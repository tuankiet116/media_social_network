import UserPostComponent from './UserPostComponent.vue';
import FollowersComponent from './FollowersComponent.vue';
import FollowingComponent from './FollowingComponent.vue'
import { detectUser } from '../../api/auth';

const userRouters = [
    { path: '', component: UserPostComponent, name: "profile_list_post" },
    { path: 'followers', component: FollowersComponent, name: "profile_list_follower" },
    { path: 'following', component: FollowingComponent, name: "profile_list_following" }
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