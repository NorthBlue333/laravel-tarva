import {
    DefineComponent,
    defineComponent,
    PropType,
    ref,
    resolveComponent,
    Teleport,
} from 'vue'
import Base from '../../Layouts/Base'
import {
    FormInstanciatedPanel,
    InstanciatedField,
    InstanciatedPanel,
    ResourceInstance,
} from '../../types/resources'
import { route } from '../../ziggy'
import { useForm } from '@inertiajs/inertia-vue3'

const Show = defineComponent({
    layout: Base,
    props: {
        resource: {
            type: Object as PropType<{
                title: string
                singular: string
                plural: string
                uriKey: string
                _id: unknown
                panels: FormInstanciatedPanel[]
            }>,
            required: true,
        },
    },
    setup(props) {
        const form = ref(
            useForm({
                _method: 'POST',
            } as { [key: string]: any })
        )
        return {
            form,
            submit: (redirectRoute: string) => {
                form.value = useForm({
                    ...form.value.data(),
                    ['__submit-redirect']: redirectRoute,
                })
                form.value.post(
                    route('laravel-admin::resources.update', {
                        resource: props.resource.uriKey,
                        id: ['number', 'string'].includes(
                            typeof props.resource._id
                        )
                            ? (`${props.resource._id}` as string)
                            : JSON.stringify(props.resource._id),
                    })
                )
            },
        }
    },
    render() {
        return (
            <form
                class="text-gray p-4"
                method="POST"
                action={this.$route('laravel-admin::resources.update', {
                    resource: this.resource.uriKey,
                    id: ['number', 'string'].includes(typeof this.resource._id)
                        ? (`${this.resource._id}` as string)
                        : JSON.stringify(this.resource._id),
                })}
                enctype="multipart/form-data"
            >
                <Teleport to="title">
                    Edit {this.resource.singular} {this.resource.title} - Admin
                </Teleport>
                <h2 class="text-2xl font-semibold mb-4">
                    {this.resource.singular} Edit: {this.resource.title}
                </h2>
                {this.resource.panels.map((panel) => (
                    <section>
                        {panel.showTitle && (
                            <h3 class="mt-6 mb-2 font-semibold text-lg">
                                {panel.name}
                            </h3>
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
                                    value?: any
                                    errors?: any
                                    'onValue:updated': (
                                        attribute: string,
                                        value: string
                                    ) => void
                                }>
                                return (
                                    <Component
                                        field={field}
                                        value={this.form[field.attribute]}
                                        errors={
                                            Array.isArray(
                                                this.form.errors[
                                                    field.attribute
                                                ]
                                            ) ||
                                            !this.form.errors[field.attribute]
                                                ? this.form.errors[
                                                      field.attribute
                                                  ]
                                                : [
                                                      this.form.errors[
                                                          field.attribute
                                                      ],
                                                  ]
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
                            this.submit('laravel-admin::resources.show')
                        }}
                    >
                        Save and quit
                    </button>
                    <button
                        class="text-gray-medium-light hover:bg-gray-lighter bg-gray-lightest py-2 px-3 rounded-md shadow font-bold mr-4 order-1"
                        type="submit"
                        onClick={(e) => {
                            e.preventDefault()
                            this.submit('laravel-admin::resources.edit')
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
