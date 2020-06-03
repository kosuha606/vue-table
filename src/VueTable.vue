<template>
	<div class="vue-table">
		<div v-for="template in templatesOrder">
			<slot v-if="template === 'filters'" name="filter">
				<div class="vue-table-filter">
					<h3 v-if="filterComponents.length">Фильтр</h3>
					<component
							v-model="filters[component.field]"
							:key="'mass_'+component.field+component.label"
							:is="component.component"
							:name="component.field"
							:label="component.label"
							:props="component.props"
							v-for="component in filterComponents"
					></component>
					<div class="vue-table-filter-reset">
						<button @click="resetFilter" v-if="filterComponents.length">
							Сбросить
						</button>
					</div>
				</div>
			</slot>
			<slot v-if="template === 'pagination'" name="pagination_top">
				<div>
					<button v-if="pagination.appendMode" @click="pagination.nextPage()" type="button">
						Показать еще
					</button>
					<div v-else class="pagination-wrapper row">
						<ul class="pagination pull-left">
							<li class="pagination-item">
								<button class="btn btn-default" @click="pagination.gotoBegin()" type="button">В начало</button>
							</li>
							<li class="pagination-item">
								<button class="btn btn-default" @click="pagination.prevPage()" type="button">Назад</button>
							</li>
							<li :class="{'pagination-item':1, 'pagination-item__active': page == pagination.page}" v-for="page in helpers.range(1, pagination.pagesCount())">
								<button class="btn btn-default" @click="pagination.gotoPage(page)" type="button">
									{{ page }}
								</button>
							</li>
							<li class="pagination-item">
								<button class="btn btn-default" @click="pagination.nextPage()" type="button">Вперед</button>
							</li>
							<li class="pagination-item">
								<button class="btn btn-default" @click="pagination.gotoEnd()" type="button">В конец</button>
							</li>
						</ul>
						<div class="items-per-page pull-right">
							<select class="form-control" v-model="pagination.itemsPerPage">
								<option
										:selected="variant==pagination.itemsPerPage"
										v-for="variant in pagination.itemsPerPageVariants"
										:value="variant">
									{{ variant }}
								</option>
							</select>
						</div>
					</div>
				</div>
			</slot>
			<slot v-if="template === 'mass_operations'" name="mass_operations">
				<div>
					<hr>
					<h3 v-if="massOperationComponents.length">Операции</h3>
					<component
							:mass-operations="massOperations"
							:key="'mass_'+component.field+component.label"
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
						всего: {{ pagination.getTotal() }} шт.
						{{ pagination.page }}
						из {{ pagination.pagesCount() }} стр.
					</div>
					<table :class="{'table table-striped table-bordered': 1, 'table-loading': isLoading}">
						<thead>
						<tr>
							<th
									:width="component.attrs ? component.attrs.width : ''"
									v-for="component in cellComponents">
								{{ component.label }}
								<div v-if="component.field" class="table-sort">
									<button :class="{'btn btn-default': 1, 'table-sort-active': (sort.field == component.field) && (sort.direction == 'desc')}" @click="onSort(component.field, 'desc')" type="button">&uarr;</button>
									<button :class="{'btn btn-default': 1, 'table-sort-active': (sort.field == component.field) && (sort.direction == 'asc')}" @click="onSort(component.field, 'asc')" type="button">&darr;</button>
								</div>
							</th>
						</tr>
						</thead>
						<tbody>
						<tr v-for="(item, index) in items">
							<template v-for="component in cellComponents">
								<component
										v-if="component.massOperation"
										@mass-select="onMassComponentSelect($event, component)"
										@mass-unselect="onMassComponentUnselect($event, component)"
										:key="index+'_'+component.field+component.label"
										:mass-operations="massOperations"
										:component="component"
										:is="component.component"
										:field="component.field"
										:props="component.props"
										:item="item"
								></component>
								<component
										v-else
										:key="index+'_'+component.field+component.label"
										:is="component.component"
										:field="component.field"
										:props="component.props"
										:item="item"
										:value="item[component.field]"
								></component>
							</template>
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
import SumSelectedButton from "./SumSelectedButton";

const defaultItemsPerPageVariants = [10, 20, 30, 40, 50];
const defaultItemsPerPage = 10;

const helpers = {
	range: function* (lorange,hirange){
		var n = lorange;
		while (n <= hirange){
			yield n++;
		}
	},
	addParamToUrl(paramStr) {
		let result = '';
		if(location.search === "") {
			result = location.href + "?"+paramStr;
		} else {
			result = location.href + "&"+paramStr;
		}

		return result;
	}
};

export default {
	components: {
		StringCell,
		FilterInput,
		Button,
		CheckboxCell,
		SumSelectedButton,
	},
	props: {
		id: String,
		syncUrl: [String, Function],
		paginationAppendMode: {
			type: Boolean,
			default: false,
		},
		itemsPerPage: {
			type: Number,
			default: defaultItemsPerPage,
		},
		itemsPerPageVariants: {
			type: Array,
			default: () => defaultItemsPerPageVariants,
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
		defaultSort: {
			type: Object,
			default: () => { return {field: 'id', direction: 'asc'}; }
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
	watch: {
		listState: {
			handler() {
				this.loadList()
			},
			deep: true,
		}
	},
	data() {
		const vm = this;

		return {
			isLoading: false,
			filters: {},
			massOperations: {},
			items: [],
			itemsTotal: 10,
			sort: {
				field: 'id',
				direction: 'asc',
			},
			pagination: {
				page: 1,
				itemsPerPage: defaultItemsPerPage,
				itemsPerPageVariants: defaultItemsPerPageVariants,
				total: 10,
				appendMode: false,
				getTotal() {
					if (!this) {
						return 1;
					}
					return vm.itemsTotal;
				},
				getOffsetBegin() {
					if (!this) {
						return 1;
					}
					return (this.page-1)*this.itemsPerPage;
				},
				getOffsetEnd() {
					if (!this) {
						return 1;
					}
					let possibleEnd = this.page*this.itemsPerPage;
					if (possibleEnd > this.getTotal()) {
						return this.getTotal();
					}

					return possibleEnd;
				},
				pagesCount() {
					if (!this) {
						return 1;
					}
					return Math.round((this.getTotal()/this.itemsPerPage)+0.5);
				},
				gotoEnd() {
					if (!this) {
						return 1;
					}
					this.page = this.pagesCount();
					vm.$forceUpdate();
				},
				gotoBegin() {
					if (!this) {
						return 1;
					}
					this.page = 1;
					vm.$forceUpdate();
				},
				gotoPage(page) {
					if (!this) {
						return 1;
					}
					this.page = page;
					vm.$forceUpdate();
				},
				nextPage() {
					if (!this) {
						return 1;
					}
					if (this.page >= this.pagesCount()) {
						return;
					}
					this.page = this.page+1;
					vm.$forceUpdate();
				},
				prevPage() {
					if (!this) {
						return 1;
					}
					if (this.page <= 1) {
						return;
					}
					this.page = this.page-1;
					vm.$forceUpdate();
				}
			},
			helpers: helpers,
		}
	},
	computed: {
		cookieKey() {
			return 'vue-table-'+this.id;
		},
		listState() {
			return  {
				pagination: this.pagination,
				filters: this.filters,
				mass_operations: this.massOperations,
				sort: this.sort,
			};
		},
	},
	mounted() {
		this.sort = this.defaultSort;
		this.pagination.itemsPerPage = this.itemsPerPage;
		this.pagination.itemsPerPageVariants = this.itemsPerPageVariants;
		this.pagination.appendMode = this.paginationAppendMode;
		this.unserializeStateFromUrl();
		this.loadList();
	},
	methods: {
		resetFilter() {
			this.filters = {};
			this.$forceUpdate();
		},
		onSort(field, direction) {
			this.sort = {
				field: field,
				direction: direction,
			};
			this.$forceUpdate();
		},
		onMassComponentSelect(value, component) {
			if (!this.massOperations[component.massOperation]) {
				this.massOperations[component.massOperation] = {};
			}
			this.massOperations[component.massOperation][value] = value;
			this.$forceUpdate();
		},
		onMassComponentUnselect(value, component) {
			delete(this.massOperations[component.massOperation][value]);
			this.$forceUpdate();
		},
		onMassComponentChanged(e, component) {
			if (!component.massOperation) {
				return;
			}
			if (this.massOperations[component.massOperation]) {
				this.massOperations[component.massOperation].push(e);
			} else {
				this.massOperations[component.massOperation] = [e];
			}
		},
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

			this.isLoading = true;

			let success = (response) => {
				this.items = response.data.items;
				this.isLoading = false;
				this.itemsTotal = response.data.total;
				this.$forceUpdate();
				this.serializeStateToUrl();
			};

			if (typeof(this.syncUrl) === 'function') {
				this.syncUrl(success, this.listState);
				return;
			}

			axios.get(this.syncUrl, this.listState)
				.then(success)
				.catch((response) => {
				this.isLoading = false;
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
		serializeStateToUrl() {
			const parsedUrl = new URL(window.location.href);
			parsedUrl.searchParams.set(this.id, 'on');
			window.history.pushState({}, '', parsedUrl.href);
			this.$cookie.set(this.cookieKey, JSON.stringify(this.listState));
		},
		/**
		 * Восстановить состояние из урл
		 */
		unserializeStateFromUrl() {
			const parsedUrl = new URL(window.location.href);
			if (!parsedUrl.searchParams.get(this.id)) {
				return;
			}
			if (!this.$cookie) {
				return;
			}
			let state = this.$cookie.get(this.cookieKey);
			if (!state) {
				return;
			}

			state = JSON.parse(state);
			this.pagination.page = state.pagination.page;
			this.pagination.itemsPerPage = state.pagination.itemsPerPage;
			this.filters = state.filters;
			this.sort = state.sort;
			this.mass_operations = state.mass_operations;
		},
	}
}

</script>







