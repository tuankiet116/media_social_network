import SearchPost from './SearchPost';
import SearchCommunity from './SearchCommunity';
import SearchUser from './SearchUser';
import SearchResultComponent from './SearchResultComponent';

const routes = [
    { path: 'all/:keyword', name: 'search_page', component: SearchResultComponent },
    { path: 'post/:keyword', name: 'search_post', component: SearchPost },
    { path: 'user/:keyword', name: 'search_user', component: SearchUser },
    { path: 'community/:keyword', name: 'search_community', component: SearchCommunity },
];

export default routes;