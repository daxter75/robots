import Vue from 'vue';
import VueRouter from 'vue-router';
import StartComponent from "./components/StartComponent";
import RobotList from "./views/RobotList";

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
            component: RobotList,
            meta: {title: 'Robots'}
        },
    ],
    mode: 'history'
});
