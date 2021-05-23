import { createApp, defineAsyncComponent, h } from 'vue'
import { App, plugin } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import type route from 'ziggy-js'

const el = document.getElementById('app')

if (!el) {
    throw new Error('You have to create #app element!')
}

const app = createApp({
    setup() {
        const title = document.getElementsByTagName('title')[0]
        if (!title) return
        ;(title as unknown as HTMLHeadElement).innerHTML = ''
    },
    render: () =>
        h(App, {
            initialPage: JSON.parse(el.dataset.page ?? 'Home'),
            resolveComponent: (name) =>
                import(`./Pages/${name}`).then((module) => module.default),
        }),
})
app.config.globalProperties.$route = (
    window as unknown as {
        route: typeof route
    }
).route
app.use(plugin)
app.mount(el)

app.component(
    'ViewText',
    defineAsyncComponent(() => import('./Components/Fields/View/Text'))
)
app.component(
    'ViewTextarea',
    defineAsyncComponent(() => import('./Components/Fields/View/Textarea'))
)
app.component(
    'ViewWysiwyg',
    defineAsyncComponent(() => import('./Components/Fields/View/Wysiwyg'))
)

app.component(
    'FormText',
    defineAsyncComponent(() => import('./Components/Fields/Form/Text'))
)
app.component(
    'FormTextarea',
    defineAsyncComponent(() => import('./Components/Fields/Form/Textarea'))
)
app.component(
    'FormWysiwyg',
    defineAsyncComponent(() => import('./Components/Fields/Form/Wysiwyg'))
)

InertiaProgress.init()
