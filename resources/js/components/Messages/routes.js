import ListMessages from './ListMessages';
import MessageComponent from './MessageComponent';

const routes = [
    { path: '', name: 'list_chat', component: ListMessages },
    { path: ':id', name: 'message', component: MessageComponent }
];

export default routes; 