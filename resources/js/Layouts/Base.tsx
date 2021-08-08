import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'
import { defineComponent, onMounted, onUnmounted, Ref, ref } from 'vue'
import AlertBar from '../Components/AlertBus'
import Drawer from '../Components/Drawer'
import Navbar from '../Components/Navbar'

const Base = defineComponent({
  setup() {
    const page = ref(usePage())
    const flashMessages = ref(
      page.value.props.flash?.['laravel-tarva--flash-messages']?.alerts
    )
    let removeEventListener: () => void = () => undefined
    onMounted(() => {
      removeEventListener = Inertia.on('finish', (event) => {
        flashMessages.value =
          page.value.props.flash?.['laravel-tarva--flash-messages']?.alerts
      })
    })
    onUnmounted(removeEventListener)
    return {
      isOpen: ref(true),
      isLocked: ref(true),
      flashMessages,
    }
  },
  render() {
    return (
      <div class="z-50 fixed top-0 left-0 h-screen w-screen flex">
        <Drawer
          onMouse:enter={() => {
            if (this.isOpen) return
            this.isOpen = true
          }}
          onMouse:leave={() => {
            if (!this.isOpen || this.isLocked) return
            this.isOpen = false
          }}
          isOpen={this.isOpen}
        />
        <div
          class="w-full h-full flex-grow overflow-y-auto flex flex-col"
          id="scrollable-main-content"
        >
          <Navbar
            onArrow:clicked={() => {
              this.isLocked = !this.isLocked
              this.isOpen = this.isLocked
            }}
            isLocked={this.isLocked}
          />
          {this.$slots.default ? this.$slots.default() : null}
        </div>
        {!!this.flashMessages?.length && (
          <AlertBar alerts={this.flashMessages} />
        )}
      </div>
    )
  },
})

export default Base
