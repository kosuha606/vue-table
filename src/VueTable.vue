<template>
	<div class="vue-table">
		<div v-for="template in templatesOrder">
			<slot v-if="template === 'filters'" name="filter">
				<div>
					<h3>Фильтр</h3>
					<component
							:key="'mass_'+component.field"
							:is="component.component"
							:props="component.props"
							v-for="component in filterComponents"
					></component>
				</div>
			</slot>
			<slot v-if="template === 'pagination'" name="pagination_top">
				<div>
					<button v-if="pagination.appendMode" @click="pagination.nextPage()" type="button">
						Показать еще
					</button>
					<div v-else class="pagination-wrapper">
						<ul class="pagination">
							<li class="pagination-item">
								<button type="button">В начало</button>
							</li>
							<li class="pagination-item">
								<button type="button">Назад</button>
							</li>
							<li class="pagination-item" v-for="page in helpers.range(1, pagination.pagesCount())">
								<button type="button">
									{{ page }}
								</button>
							</li>
							<li class="pagination-item">
								<button type="button">Вперед</button>
							</li>
							<li class="pagination-item">
								<button type="button">В конец</button>
							</li>
						</ul>
						<div class="items-per-page">
							<select>
								<option v-for="variant in pagination.itemsPerPageVariants" :value="variant">{{ variant }}</option>
							</select>
						</div>
					</div>
				</div>			
			</slot>
			<slot v-if="template === 'mass_operations'" name="mass_operations">
				<div>
					<hr>
					<h3>Операции</h3>
					<component
							:key="'mass_'+component.field"
							:is="component.component"
							:props="component.props"
							v-for="component in massOperationComponents"
					></component>
				</div>			
			</slot>
			<slot v-if="template === 'list'" name="list">
				<div>
					<div class="table-info">
						записи с {{ pagination.getOffsetBegin()+1 }}
						по {{ pagination.getOffsetEnd() }},
						всего: {{ pagination.total }} шт.
						на {{ pagination.pagesCount() }} стр.
					</div>
					<table class="table">
						<thead>
							<tr>
								<th
									:width="component.attrs ? component.attrs.width : ''"
									v-for="component in cellComponents">
									{{ component.label }}
									<div v-if="component.field" class="table-sort">
										<button type="button">&uarr;</button>
										<button type="button">&darr;</button>
									</div>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item, index) in items">
								<component
										:key="index+'_'+component.field"
										:is="component.component"
										:field="component.field"
										:props="component.props"
										:item="item"
										v-for="component in cellComponents"
								></component>
							</tr>
						</tbody>
					</table>
				</div>			
			</slot>
		</div>
	</div>
</template>

<script>

import axios from 'axios';
import StringCell from "./StringCell";
import FilterInput from "./FilterInput";
import Button from "./Button";
import CheckboxCell from "./CheckboxCell";

let pagination = {
	page: 1,
	itemsPerPage: 10,
	itemsPerPageVariants: [10, 20, 30, 40, 50],
	total: 10,
	appendMode: false,
	getOffsetBegin() {
		return (this.page-1)*this.itemsPerPage;
	},
	getOffsetEnd() {
		return (this.page)*this.itemsPerPage;
	},
	pagesCount() {
		return Math.round(this.total/this.itemsPerPage);
	},
	gotoEnd() {

	},
	gotoBegint() {

	},
	gotoPage() {

	},
	nextPage() {

	},
	prevPage() {

	}
};

const helpers = {
	range: function* (lorange,hirange){
		var n = lorange;
		while (n <= hirange){
			yield n++;
		}
	}
};

export default {
	components: {
		StringCell,
		FilterInput,
		Button,
		CheckboxCell,
	},
	props: {
		id: String,
		syncUrl: String,
		paginationAppendMode: {
			type: Boolean,
			default: pagination.appendMode,
		},
		itemsPerPage: {
			type: Number,
			default: pagination.itemsPerPage,
		},
		itemsPerPageVariants: {
			type: Array,
			default: () => pagination.itemsPerPageVariants,
		},
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
			pagination: pagination,
			helpers: helpers,
		}
	},
	mounted() {
		this.pagination.itemsPerPage = this.itemsPerPage;
		this.pagination.itemsPerPageVariants = this.itemsPerPageVariants;
		this.loadList();
	},
	methods: {
		printComponentAttrs(component) {
			return 'hhh';
		},
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
				this.pagination.total = response.data.total;
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







