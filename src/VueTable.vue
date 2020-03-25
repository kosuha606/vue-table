<template>
	<div>
		<div v-for="template in templatesOrder">
			<slot v-if="template === 'filters'" name="filter">
				<div>			
					filters
				</div>
			</slot>
			<slot v-if="template === 'pagination_top'" name="pagination_top">
				<div>			
					pagination_top
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
			<slot v-if="template === 'pagination_bottom'" name="pagination_bottom">
				<div>			
					pagination_bottom
				</div>			
			</slot>
		</div>
	</div>
</template>

<script>

export default {
	data() {
		return {
			templatesOrder: [
				'filters',
				'mass_operations',
				'pagination_top',
				'list',
				'pagination_bottom'
			],
			hello: 'world'
		}
	},
	methods: {
		/**
		 * Загрузить список
		 */
		loadList(paginatorInstance, filtersSet, sortInstance) {
			
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







