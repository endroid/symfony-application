import Vue from 'vue'
import UserApp from './UserApp'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
	el: '#app',
	template: '<UserApp/>',
	components: { UserApp }
})
