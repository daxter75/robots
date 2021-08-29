import Vue from 'vue';
import VueRouter from 'vue-router';
import StartComponent from "./components/StartComponent";
import RobotsIndex from "./views/RobotsIndex";
import RobotsShow from "./views/RobotsShow";
import DanceoffsIndex from "./views/DanceoffsIndex";
import LeaderboardIndex from "./views/LeaderboardIndex";
import DanceoffsCreate from "./views/DanceoffsCreate";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: StartComponent,
            meta: {title: 'Welcome'}
        },
        {
            path: '/robots',
            component: RobotsIndex,
            meta: {title: 'Robots'}
        },
        {
            path: '/robots/:id',
            component: RobotsShow,
            meta: {title: 'Robot Details'}
        },
        {
            path: '/danceoffs',
            component: DanceoffsIndex,
            meta: {title: 'Danceoffs'}
        },
        {
            path: '/leaderboard',
            component: LeaderboardIndex,
            meta: {title: 'Leaderboard'}
        },
        {
            path: '/danceoffs/create',
            component: DanceoffsCreate,
            meta: {title: 'New danceoff'}
        },
    ],
    mode: 'history'
});
