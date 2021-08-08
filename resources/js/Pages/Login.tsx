import { useForm } from '@inertiajs/inertia-vue3'
import { defineComponent, ref } from 'vue'
import { route } from '../ziggy'

const Login = defineComponent({
  setup() {
    const form = ref(
      useForm({
        _method: 'post',
        email: '',
        password: '',
      })
    )
    return {
      form,
      onSubmit: () => {
        form.value.post(route('login'))
      },
    }
  },
  render() {
    return (
      <div class="bg-gray-200 min-h-screen flex items-center justify-center">
        <form
          method="post"
          action={this.$route('login')}
          class="rounded-lg bg-gray-600 shadow p-8 flex flex-wrap text-white"
          onSubmit={(e) => {
            e.preventDefault()
            this.onSubmit()
          }}
        >
          {(this.form.errors.email || this.form.errors.email) && (
            <span class="w-full">Invalid credentials.</span>
          )}
          <input
            type="text"
            name="email"
            id="email"
            placeholder="example@abc.xyz"
            class="my-2 w-full p-2 text-gray-800"
            v-model={this.form.email}
          />
          <input
            type="password"
            name="password"
            id="password"
            placeholder="password"
            class="my-2 w-full p-2 text-gray-800"
            v-model={this.form.password}
          />
          <button
            class="my-2 py-2 px-4 bg-gray-200 text-gray-600 w-full rounded-lg hover:bg-gray-300 focus:outline-none"
            type="submit"
          >
            Login
          </button>
        </form>
      </div>
    )
  },
})

export default Login
