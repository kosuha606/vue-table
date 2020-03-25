
import Vue from 'vue';
import VueTable from './VueTable';




const app = new Vue({
	el: '#app',
	components: {
		VueTable,
	},
	data() {
		return {
			items: [
				{
					name: 'One',
					category: 'CategoryOne',
					date: '12-12-12',
				},
				{
					name: 'Two',
					category: 'CategoryTwo',
					date: '12-12-12',
				},
				{
					name: 'Three',
					category: 'CategoryThree',
					date: '12-12-12',
				},
				{
					name: 'Four',
					category: 'CategoryFour',
					date: '12-12-12',
				},
				{
					name: 'Five',
					category: 'CategoryFive',
					date: '12-12-12',
				},
			]
		}
	}
});
