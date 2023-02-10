import ListMessages from './ListMessages';
import MessageComponent from './MessageComponent';
import { detectUser } from '../../api/auth';

const routes = [
    { path: '', name: 'list_chat', component: ListMessages, beforeEnter: checkAuth },
    { path: ':id', name: 'message', component: MessageComponent, beforeEnter: checkAuth }
];

async function checkAuth(to, from, next) {
    let user = await detectUser().then(result => result.data).catch(error => { });
    if (user) {
        next();
    } else {
        window.sessionStorage.removeItem('user');
        window.location.href = '/user/login';
    }
}
export default routes;