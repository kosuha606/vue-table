
import Vue from 'vue';
import VueTable from './VueTable';
import StringCell from "./StringCell";

Vue.component('string-cell', StringCell);


const app = new Vue({
	el: '#app',
	components: {
		VueTable,
		StringCell,
	},
	data() {
		return {
		}
	}
});
