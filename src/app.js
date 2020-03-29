
import Vue from 'vue';
import VueTable from './VueTable';
import StringCell from "./StringCell";
import VueCookie from 'vue-cookie';
import SumSelectedButton from "./SumSelectedButton";

Vue.component('string-cell', StringCell);
Vue.use(VueCookie);
Vue.component('SumSelectedButton', SumSelectedButton);


const app = new Vue({
	el: '#app',
	components: {
		VueTable,
		StringCell,
        SumSelectedButton,
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
