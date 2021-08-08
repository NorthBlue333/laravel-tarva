import {
  DefineComponent,
  defineComponent,
  PropType,
  ref,
  resolveComponent,
} from 'vue'
import Base from '../../Layouts/Base'
import {
  FormResourceInstance,
  InstanciatedField,
  ResourceProperties,
} from '../../types/resources'
import { route } from '../../ziggy'
import { useForm, Head } from '@inertiajs/inertia-vue3'

const Show = defineComponent({
  layout: Base,
  props: {
    resource: {
      type: Object as PropType<FormResourceInstance & ResourceProperties>,
      required: true,
    },
  },
  setup(props) {
    const form = ref(
      useForm({
        _method: 'POST',
      } as Record<string, any>)
    )
    return {
      form,
      submit: (redirectRoute: string) => {
        form.value = useForm({
          ...form.value.data(),
          ['__submit-redirect']: redirectRoute,
        })
        form.value.post(
          route('laravel-tarva::resources.update', {
            resource: props.resource.uriKey,
            id: ['number', 'string'].includes(typeof props.resource._id)
              ? `${props.resource._id}`
              : JSON.stringify(props.resource._id),
          }),
          {
            onError() {
              const scrollY = Object.keys(form.value.errors).reduce(
                (acc, fieldId) => {
                  const fieldPosition = document
                    .querySelector(`#${fieldId}`)
                    ?.getBoundingClientRect()
                  if (!fieldPosition || acc < fieldPosition.top) return acc
                  return fieldPosition.top
                },
                0
              )
              const mainContent = document.querySelector(
                '#scrollable-main-content'
              )
              if (!mainContent) return

              mainContent.scroll({
                top: Math.max(0, mainContent.scrollTop + scrollY - 15),
              })
            },
          }
        )
      },
    }
  },
  render() {
    return (
      <form
        class="text-gray p-4"
        method="POST"
        action={this.$route('laravel-tarva::resources.update', {
          resource: this.resource.uriKey,
          id: ['number', 'string'].includes(typeof this.resource._id)
            ? (`${this.resource._id}` as string)
            : JSON.stringify(this.resource._id),
        })}
        enctype="multipart/form-data"
      >
        <Head title={`Edit ${this.resource.singular} ${this.resource.title}`} />
        <h2 class="text-2xl font-semibold mb-4">
          {this.resource.singular} Edit: {this.resource.title}
        </h2>
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
              {panel.fields.map((field) => {
                const Component = resolveComponent(
                  field.component
                ) as DefineComponent<{
                  field: InstanciatedField<any>
                  value?: any
                  errors?: any
                  'onValue:updated': (attribute: string, value: unknown) => void
                }>
                return (
                  <Component
                    field={field}
                    value={this.form[field.attribute]}
                    errors={
                      Array.isArray(this.form.errors[field.attribute]) ||
                      !this.form.errors[field.attribute]
                        ? this.form.errors[field.attribute]
                        : [this.form.errors[field.attribute]]
                    }
                    onValue:updated={(attribute, value) =>
                      (this.form = useForm({
                        ...this.form.data(),
                        [attribute]: value,
                      }))
                    }
                  />
                )
              })}
            </div>
          </section>
        ))}
        <div class="mt-4 flex justify-end">
          <button
            class="bg-tertiary hover:bg-tertiary-shadow text-ghost-white font-bold py-2 px-3 rounded-md shadow order-2"
            type="submit"
            onClick={(e) => {
              e.preventDefault()
              this.submit('laravel-tarva::resources.show')
            }}
          >
            Save and quit
          </button>
          <button
            class="text-gray-medium-light hover:bg-gray-lighter bg-gray-lightest py-2 px-3 rounded-md shadow font-bold mr-4 order-1"
            type="submit"
            onClick={(e) => {
              e.preventDefault()
              this.submit('laravel-tarva::resources.edit')
            }}
          >
            Save and continue
          </button>
        </div>
      </form>
    )
  },
})

export default Show
