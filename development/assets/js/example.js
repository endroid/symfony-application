import Vue from 'vue'
import ExampleApp from './ExampleApp'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
	el: '#app',
	template: '<ExampleApp/>',
	components: { ExampleApp }
})
