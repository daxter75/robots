import Vue from 'vue';
import VueRouter from 'vue-router';
import StartComponent from "./components/StartComponent";
import RobotsIndex from "./views/RobotsIndex";
import RobotsShow from "./views/RobotsShow";

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
    ],
    mode: 'history'
});
