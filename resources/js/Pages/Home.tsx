import { defineComponent } from 'vue'
import Base from '../Layouts/Base'
import { Head } from '@inertiajs/inertia-vue3'

const Home = defineComponent({
  layout: Base,
  render() {
    return (
      <div class="p-4">
        <Head title="Home" />
        This is your admin panel. You can navigate through it with the drawer on
        the left.
      </div>
    )
  },
})

export default Home
