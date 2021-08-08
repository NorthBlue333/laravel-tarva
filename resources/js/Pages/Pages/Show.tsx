import {
  DefineComponent,
  defineComponent,
  PropType,
  resolveComponent,
} from 'vue'
import Base from '../../Layouts/Base'
import { Head } from '@inertiajs/inertia-vue3'
import { Page } from 'resources/js/types/pages'

const Show = defineComponent({
  layout: Base,
  props: {
    page: {
      type: Object as PropType<Page>,
      required: true,
    },
  },
  render() {
    const Component = resolveComponent(this.page.component) as DefineComponent<{
      page: Page
    }>
    return (
      <div class="text-gray p-4">
        <Head title={`${this.page.name}`}>
          {this.page.additionalCssFiles.map((link) => (
            <link rel="stylesheet" href={link} />
          ))}
          {this.page.additionalJsFiles.map((link) => (
            <script src={link} />
          ))}
        </Head>
        <div class="flex">
          <h2 class="text-2xl font-semibold mb-4">{this.page.name}</h2>
        </div>
        <section>
          <h3 class="mt-6 mb-2 font-semibold text-lg">{this.page.name}</h3>
          <div class="shadow rounded-md border border-gray-lighter bg-white mt-6">
            <Component page={this.page} />
          </div>
        </section>
      </div>
    )
  },
})

export default Show
