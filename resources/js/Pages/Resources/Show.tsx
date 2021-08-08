import {
  DefineComponent,
  defineComponent,
  PropType,
  resolveComponent,
} from 'vue'
import Base from '../../Layouts/Base'
import {
  ShowResourceInstance,
  InstanciatedField,
  ResourceProperties,
} from '../../types/resources'
import { Head, Link } from '@inertiajs/inertia-vue3'

const Show = defineComponent({
  layout: Base,
  props: {
    resource: {
      type: Object as PropType<ShowResourceInstance & ResourceProperties>,
      required: true,
    },
  },
  render() {
    return (
      <div class="text-gray p-4">
        <Head title={`${this.resource.singular} ${this.resource.title}`} />
        <div class="flex">
          <h2 class="text-2xl font-semibold mb-4">
            {this.resource.singular} Details: {this.resource.title}
          </h2>
          <ul class="ml-auto">
            <li>
              <Link
                class="text-gray-medium-light hover:text-tertiary bg-gray-lighter py-2 px-3 rounded-md shadow"
                href={this.$route('laravel-tarva::resources.edit', {
                  resource: this.resource.uriKey,
                  id: ['number', 'string'].includes(typeof this.resource._id)
                    ? (`${this.resource._id}` as string)
                    : JSON.stringify(this.resource._id),
                })}
              >
                <i class="fas fa-edit"></i>
              </Link>
            </li>
          </ul>
        </div>
        {this.resource.panels.map((panel) => (
          <section>
            {panel.showTitle && (
              <h3 class="mt-6 mb-2 font-semibold text-lg">{panel.name}</h3>
            )}
            <div
              class={[
                'shadow rounded-md border border-gray-lighter bg-white',
                panel.showTitle ? null : 'mt-6',
              ]}
            >
              {panel.fields.map((field, idx) => {
                const Component = resolveComponent(
                  field.component
                ) as DefineComponent<{
                  field: InstanciatedField<any>
                }>
                return <Component field={field} />
              })}
            </div>
          </section>
        ))}
      </div>
    )
  },
})

export default Show
