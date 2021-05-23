import { Inertia } from '@inertiajs/inertia'
import { useForm, usePage } from '@inertiajs/inertia-vue3'
import { defineComponent, PropType, ref, watch } from 'vue'
import { InputValue } from 'ziggy-js'
import { route } from '../ziggy'

const Drawer = defineComponent({
    props: {
        isOpen: {
            type: Boolean,
            required: true,
        },
        'onMouse:enter': {
            type: Function as PropType<() => void>,
        },
        'onMouse:leave': {
            type: Function as PropType<() => void>,
        },
    },
    emits: {
        'mouse:enter': () => true,
        'mouse:leave': () => true,
    },
    setup() {
        const currentRoute = ref(route().current())
        const currentRouteParams = ref(
            route().params as {
                [key: string]: InputValue
            }
        )
        const page = ref(usePage())
        const logoutForm = ref(
            useForm({
                _method: 'POST',
            })
        )
        watch(
            page,
            () => {
                currentRoute.value = route().current()
                currentRouteParams.value = route().params as {
                    [key: string]: InputValue
                }
            },
            { deep: true }
        )
        return {
            page,
            currentRoute,
            currentRouteParams,
            logout: () =>
                logoutForm.value.post(route('logout'), {
                    onSuccess: () => Inertia.reload(),
                }),
        }
    },
    render() {
        return (
            <nav
                onMouseenter={() => this.$emit('mouse:enter')}
                onMouseleave={() => this.$emit('mouse:leave')}
                class={[
                    'h-full bg-gray-dark flex flex-col text-ghost-white overflow-hidden flex-shrink-0',
                    // transition-size duration-200
                    this.isOpen ? 'w-56' : 'w-16',
                ]}
            >
                <div
                    class={[
                        'text-tertiary w-full h-52 text-center flex flex-col items-center justify-center flex-shrink-0',
                        this.isOpen ? 'px-6' : 'px-2',
                    ]}
                >
                    <i class="far fa-user-circle text-3xl transition-size duration-200 block w-full pt-2"></i>
                    {this.$page.props.user?.email && (
                        <p
                            class={[
                                'font-bold pt-4 transition-opacity duration-200',
                                this.isOpen ? null : 'opacity-0 hidden',
                            ]}
                        >
                            {this.$page.props.user.email}
                        </p>
                    )}
                    <form
                        class="opacity-75"
                        action={this.$route('logout')}
                        method="POST"
                        onSubmit={(e) => {
                            e.preventDefault()
                            this.logout()
                        }}
                    >
                        <button class="px-2 py-1 hover:underline" type="submit">
                            <i class="fas fa-sign-out-alt"></i>
                            <span
                                class={[
                                    'ml-2 transition-opacity duration-200',
                                    this.isOpen ? null : 'opacity-0 hidden',
                                ]}
                            >
                                Déconnexion
                            </span>
                        </button>
                    </form>
                </div>
                <ul
                    class={[
                        'flex flex-col h-full pt-4 text-ghost-white',
                        this.isOpen ? 'px-6 items-start' : 'px-2 items-center',
                    ]}
                >
                    <li>
                        <inertia-link
                            class={[
                                'py-2 px-4 block group hover:opacity-75 text-center transition duration-200',
                                this.currentRoute === 'laravel-admin::home'
                                    ? 'font-bold'
                                    : null,
                            ]}
                            href={this.$route('laravel-admin::home')}
                        >
                            <i class="fas fa-home tex"></i>
                            <span
                                class={[
                                    'pl-2 group-hover:pl-4 transition-all duration-200',
                                    this.isOpen ? null : 'opacity-0 hidden',
                                ]}
                            >
                                Home
                            </span>
                        </inertia-link>
                    </li>
                    <li class="py-2 px-4 uppercase opacity-75 text-center transition duration-200">
                        <i class="fas fa-stream"></i>
                        <span
                            class={[
                                'pl-2 text-sm transition-opacity duration-200',
                                this.isOpen ? null : 'opacity-0 hidden',
                            ]}
                        >
                            Resources
                        </span>
                    </li>
                    {this.$page.props.adminResourceClasses.map(
                        (resourceClass) => (
                            <li class="transition-size duration-200">
                                {this.currentRoute ===
                                    'laravel-admin::resources.list' &&
                                this.currentRouteParams.resource ===
                                    resourceClass.uriKey ? (
                                    <p class="py-1 px-4 block opacity-75 text-center transition duration-200 font-bold">
                                        {resourceClass.icon && (
                                            <i
                                                class={`fas ${resourceClass.icon}`}
                                            ></i>
                                        )}
                                        <span
                                            class={[
                                                'pl-4 transition-all duration-200',
                                                this.isOpen
                                                    ? null
                                                    : 'opacity-0 hidden',
                                            ]}
                                        >
                                            {resourceClass.plural}
                                        </span>
                                    </p>
                                ) : (
                                    <inertia-link
                                        class="py-1 px-4 block group hover:opacity-75 text-center transition duration-200"
                                        href={this.$route(
                                            'laravel-admin::resources.list',
                                            { resource: resourceClass.uriKey }
                                        )}
                                    >
                                        {resourceClass.icon && (
                                            <i
                                                class={`fas ${resourceClass.icon}`}
                                            ></i>
                                        )}
                                        <span
                                            class={[
                                                'pl-2 group-hover:pl-4 transition-all duration-200',
                                                this.isOpen
                                                    ? null
                                                    : 'opacity-0 hidden',
                                            ]}
                                        >
                                            {resourceClass.plural}
                                        </span>
                                    </inertia-link>
                                )}
                            </li>
                        )
                    )}
                </ul>
            </nav>
        )
    },
})

export default Drawer
