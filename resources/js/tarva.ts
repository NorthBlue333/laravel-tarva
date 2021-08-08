import { createApp, defineAsyncComponent, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import type route from 'ziggy-js'

const el = document.getElementById('app')

if (!el) {
  throw new Error('You have to create #app element!')
}

createInertiaApp({
  resolve: (name) => require(`./Pages/${name}`),
  title: (title) => `${title} - Tarva`,
  setup({ el, app, props, plugin }) {
    const vueApp = createApp({
      render: () => h(app, props),
    })

    vueApp.config.globalProperties.$route = (
      window as unknown as {
        route: typeof route
      }
    ).route

    /** View Components */
    vueApp.component(
      'ViewMedia',
      defineAsyncComponent(() => import('./Components/Fields/View/Media'))
    )
    vueApp.component(
      'ViewText',
      defineAsyncComponent(() => import('./Components/Fields/View/Text'))
    )
    vueApp.component(
      'ViewTextarea',
      defineAsyncComponent(() => import('./Components/Fields/View/Textarea'))
    )
    vueApp.component(
      'ViewWysiwyg',
      defineAsyncComponent(() => import('./Components/Fields/View/Wysiwyg'))
    )

    /** Form Components */
    vueApp.component(
      'FormMedia',
      defineAsyncComponent(() => import('./Components/Fields/Form/Media'))
    )
    vueApp.component(
      'FormText',
      defineAsyncComponent(() => import('./Components/Fields/Form/Text'))
    )
    vueApp.component(
      'FormTextarea',
      defineAsyncComponent(() => import('./Components/Fields/Form/Textarea'))
    )
    vueApp.component(
      'FormWysiwyg',
      defineAsyncComponent(() => import('./Components/Fields/Form/Wysiwyg'))
    )

    vueApp.use(plugin)
    vueApp.mount(el)
  },
})

InertiaProgress.init()
