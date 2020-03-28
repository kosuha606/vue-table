<template>
	<div>
		<div v-for="template in templatesOrder">
			<slot v-if="template === 'filters'" name="filter">
				<div>			
					filters
				</div>
			</slot>
			<slot v-if="template === 'pagination'" name="pagination_top">
				<div>			
					pagination
				</div>			
			</slot>
			<slot v-if="template === 'mass_operations'" name="mass_operations">
				<div>			
					mass_operations
				</div>			
			</slot>
			<slot v-if="template === 'list'" name="list">
				<div>			
					list
				</div>			
			</slot>
		</div>
	</div>
</template>

<script>

import axios from 'axios';

export default {
	props: {
		id: String,
		syncUrl: String,
		filterComponents: {
			type: Array,
			default: () => {return [];}
		},
		cellComponents: {
			type: Array,
			default: () => {return [];}
		},
		massOperationComponents: {
			type: Array,
			default: () => {return [];}
		},
		templatesOrder: {
			type: Array,
			default: () => {
				return [
					'filters',
					'mass_operations',
					'pagination',
					'list',
					'pagination'
				];
			}
		}
	},
	data() {
		return {
			filters: {},
			massOperations: {},
			items: [],
			pagination: {
				page: 1,
				itemsPerPage: 10,
				total: 10,
			}
		}
	},
	mounted() {
		this.loadList();
	},
	methods: {
		/**
		 * Загрузить список
		 */
		loadList(paginatorInstance, filtersSet, sortInstance) {
			if (!this.syncUrl) {
				throw new Error('SyncUrl should be specified');
			}

			axios.post(this.syncUrl, {
				pagination: this.pagination,
				filters: this.filters,
				mass_operations: this.massOperations
			}).then((response) => {
				this.items = response.data.items;
				this.$forceUpdate();
			}).catch((response) => {

			});
		},
		/**
		 * Применить массовые операции
		 */
		applyMassOperations(OperationName, MassConfig) {
		
		},
		/**
		 * Применить фильтр
		 */
		applyFilter() {
			
		},
		/**
		 * Сохранить состояние в урл
		 */
		serializeStateToUrl(paginatorInstance, filterData, SortInstance, massOperationsData) {
		
		},
		/**
		 * Восстановить состояние из урл
		 */
		unserializeStateFromUrl() {
			
		},
	}
}

</script>







