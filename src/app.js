
import Vue from 'vue';
import VueTable from './VueTable';

const app = new Vue({
	el: '#app',
	components: {
		VueTable,
	},
	data() {
		return {
			filterData: {},
			massOperationsData: {},
			paginatorInstance: {},
			sortInstance: {},
		}
	}
});
