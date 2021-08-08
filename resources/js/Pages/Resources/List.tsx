import {
  AnyFilter,
  InstanciatedField,
  InstanciatedFilter,
  InstanciatedPanel,
  Panel,
  IndexResourceInstance,
  ListResourceProperties,
  FilterTypes,
} from '../../types/resources'
import { defineComponent, onBeforeUnmount, onMounted, PropType, ref } from 'vue'
import Base from '../../Layouts/Base'
import { debounce } from 'lodash'
import { route } from '../../ziggy'
import { Inertia } from '@inertiajs/inertia'
import { Head, Link } from '@inertiajs/inertia-vue3'

const List = defineComponent({
  layout: Base,
  props: {
    resource: {
      type: Object as PropType<ListResourceProperties>,
      required: true,
    },
    resources: {
      type: Array as PropType<IndexResourceInstance[]>,
      required: true,
    },
    pagination: {
      type: Object as PropType<{
        currentPage: number
        perPage: number
        next?: string
        previous?: string
      }>,
      required: true,
    },
    fields: {
      type: Array as PropType<
        (InstanciatedField<unknown> | InstanciatedPanel)[]
      >,
      required: true,
    },
    filtersOptions: {
      type: Object as PropType<Record<string, AnyFilter<unknown>>>,
      required: true,
    },
    filters: {
      type: Object as PropType<
        Record<
          string,
          InstanciatedFilter<
            boolean | number | string | (boolean | number | string)[]
          >
        >
      >,
      required: true,
    },
  },
  setup(props) {
    const isFilterDropdownOpened = ref(false)
    const closeDropdownOnClickOutside = () => {
      isFilterDropdownOpened.value = false
    }
    const newFilters = ref(
      Object.fromEntries(
        Object.keys(props.filters).map((filter) => [
          filter,
          props.filters[filter].value,
        ])
      )
    )
    onMounted(() => {
      document.addEventListener('click', closeDropdownOnClickOutside)
    })
    onBeforeUnmount(() => {
      document.removeEventListener('click', closeDropdownOnClickOutside)
    })
    return {
      isFilterDropdownOpened,
      newFilters,
      applyFilters: debounce(() => {
        Inertia.visit(
          route('laravel-tarva::resources.list', {
            resource: props.resource.uriKey,
          }),
          {
            data: newFilters.value,
          }
        )
      }, 500),
    }
  },
  render() {
    return (
      <div class="text-gray p-4">
        <Head title={this.resource.plural} />
        <h2 class="text-2xl font-semibold mb-4">{this.resource.plural}</h2>
        <div class="rounded-md border border-gray-lighter overflow-hidden">
          <div class="py-4 px-4 flex">
            <div class="ml-auto relative">
              <div onClick={(e) => e.stopPropagation()}>
                <button
                  class="text-gray-medium-light hover:text-tertiary bg-gray-lighter py-2 px-3 rounded-md"
                  onClick={() => (this.isFilterDropdownOpened = true)}
                >
                  <i class="fas fa-filter"></i>
                </button>
                {!this.isFilterDropdownOpened ? null : (
                  <ul class="absolute top-full right-0 bg-ghost-white shadow rounded-md border-gray-light border min-w-32 text-gray-medium">
                    <li class="bg-gray-lighter border-b border-gray-light">
                      <button class="uppercase font-bold text-xs w-full p-2">
                        Reset filters
                      </button>
                    </li>
                    <li class="p-2 uppercase font-bold text-sm bg-gray-lighter">
                      Per page
                    </li>
                    <li class="p-2">
                      {Object.entries(this.filtersOptions).map(
                        ([filterName, filterOption]) => {
                          if (filterOption.type === FilterTypes.select) {
                            return (
                              <select
                                class="w-full"
                                v-model={this.newFilters[filterName]}
                                onChange={this.applyFilters}
                              >
                                {filterOption.values.map((option) => (
                                  <option
                                    selected={
                                      this.filters[filterName] === option
                                    }
                                  >
                                    {option}
                                  </option>
                                ))}
                              </select>
                            )
                          }
                        }
                      )}
                    </li>
                  </ul>
                )}
              </div>
            </div>
          </div>
          <table class="w-full">
            <thead class="bg-gray-lightest text-gray-medium font-semibold uppercase text-xs border-b border-t border-gray-lighter">
              <tr>
                {this.resources.length <= 0 ? (
                  <td class="py-2 px-4 w-16 text-right"></td>
                ) : (
                  [
                    <td class="py-2 px-4 w-16 text-right">
                      {/** checkbox */}
                    </td>,
                    ...this.fields.map((field) =>
                      field.isPanel ? (
                        (field as Panel).fields.map((subField) => (
                          <td class="py-2 px-4">{subField.name}</td>
                        ))
                      ) : (
                        <td class="py-2 px-4">{field.name}</td>
                      )
                    ),
                    <td class="py-2 px-4 w-32 text-right">Actions</td>,
                  ]
                )}
              </tr>
            </thead>
            <tbody class="text-gray font-light">
              {this.resources.map((resourceItem) => (
                <tr class="border-b border-gray-lighter hover:bg-gray-lightest">
                  <td class="py-3 px-4 text-center">
                    <input
                      type="checkbox"
                      class="rounded-md shadow-checkbox focus:outline-none focus:shadow-outline checked:shadow-none bg-white w-5 h-5 appearance-none checked:bg-tertiary checked:bg-checkbox align-middle"
                    />
                  </td>
                  {resourceItem.fields.map((field) =>
                    field.isPanel ? (
                      (field as InstanciatedPanel).fields.map((subField) => (
                        <td class="py-3 px-4">{subField.valueForDisplay}</td>
                      ))
                    ) : (
                      <td class="py-3 px-4">
                        {(field as InstanciatedField<unknown>).valueForDisplay}
                      </td>
                    )
                  )}
                  <td class="py-3 px-4 text-right text-gray-medium-light">
                    <Link
                      class="hover:text-tertiary text-lg px-1"
                      href={this.$route('laravel-tarva::resources.show', {
                        resource: this.resource.uriKey,
                        id: ['number', 'string'].includes(
                          typeof resourceItem._id
                        )
                          ? (`${resourceItem._id}` as string)
                          : JSON.stringify(resourceItem._id),
                      })}
                    >
                      <i class="fas fa-eye"></i>
                    </Link>
                    <Link
                      class="hover:text-tertiary text-lg px-1"
                      href={this.$route('laravel-tarva::resources.edit', {
                        resource: this.resource.uriKey,
                        id: ['number', 'string'].includes(
                          typeof resourceItem._id
                        )
                          ? (`${resourceItem._id}` as string)
                          : JSON.stringify(resourceItem._id),
                      })}
                    >
                      <i class="fas fa-edit"></i>
                    </Link>
                  </td>
                </tr>
              ))}
              {this.resources.length > 0 ? null : (
                <tr class="border-b border-gray-lighter">
                  <td class="p-4 text-center">
                    No {this.resource.singular.toLowerCase()}
                  </td>
                </tr>
              )}
            </tbody>
          </table>
          <nav class="text-gray-light">
            <ul class="p-4 flex justify-between">
              <li class="font-bold">
                {this.pagination.previous ? (
                  <Link href={this.pagination.previous}>Previous</Link>
                ) : (
                  <span class="text-gray-lighter cursor-not-allowed">
                    Previous
                  </span>
                )}
              </li>
              <li>
                {(this.pagination.currentPage - 1) * this.pagination.perPage +
                  (this.resources.length ? 1 : 0)}
                -{this.pagination.currentPage * this.resources.length} on{' '}
                {this.resource.totalCount}
              </li>
              <li class="font-bold">
                {this.pagination.next ? (
                  <Link href={this.pagination.next}>Next</Link>
                ) : (
                  <span class="text-gray-lighter cursor-not-allowed">Next</span>
                )}
              </li>
            </ul>
          </nav>
        </div>
      </div>
    )
  },
})

export default List
