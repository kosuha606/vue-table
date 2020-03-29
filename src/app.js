
import Vue from 'vue';
import VueTable from './VueTable';
import StringCell from "./StringCell";
import VueCookie from 'vue-cookie';

Vue.component('string-cell', StringCell);
Vue.use(VueCookie);


const app = new Vue({
	el: '#app',
	components: {
		VueTable,
		StringCell,
	},
	data() {
		return {
		}
	},
	methods: {
		test() {
			window.history.pushState({}, '', '/?123123123=1');
		}
	}
});
