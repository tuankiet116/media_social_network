import SearchPost from './SearchPost';
import SearchResultComponent from './SearchResultComponent';

const routes = [
    { path: ':keyword', name: 'search_page', component: SearchResultComponent },
    { path: '/post', name: 'search_post', component: SearchPost}
];

export default routes;