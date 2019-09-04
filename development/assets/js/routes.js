import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/Home';
import Page from './components/Page';

Vue.use(VueRouter);

const router = new VueRouter({
	mode: 'history',
	routes:[
		{ path:'/', name: 'home', component: Home },
		{ path:'/:page', name: 'page', component: Page }
	]
});

export default router;
