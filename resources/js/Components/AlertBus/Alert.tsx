import { defineComponent, onMounted, onUnmounted, PropType, ref } from 'vue'
import { AlertType, IAlert } from './types'

const Alert = defineComponent({
  props: {
    alert: {
      type: Object as PropType<IAlert>,
      required: true,
    },
    shouldHideOnTap: Boolean,
    onEnd: {
      type: Function as PropType<() => void>,
    },
  },
  emits: {
    end: () => true,
  },
  setup(props, { emit }) {
    const timeoutId = ref(-1)
    const opacity = ref(1)
    const _clearTimeout = () => {
      clearTimeout(timeoutId.value)
    }
    onMounted(() => {
      timeoutId.value = setTimeout(() => {
        opacity.value = 0
        timeoutId.value = setTimeout(() => emit('end'), 250)
      }, props.alert.duration ?? 3000)
    })
    onUnmounted(() => {
      if (!timeoutId.value) return
      _clearTimeout()
    })
    return {
      timeoutId,
      opacity,
      clearTimeout: _clearTimeout,
    }
  },
  render() {
    let bg: string
    switch (this.alert.type) {
      case AlertType.Warning:
        bg = 'bg-yellow-300'
        break
      case AlertType.Info:
        bg = 'bg-blue-300'
        break
      case AlertType.Error:
        bg = 'bg-red'
        break
      case AlertType.Success:
        bg = 'bg-green'
        break
    }
    return (
      <div
        onClick={
          this.shouldHideOnTap
            ? () => {
                this.clearTimeout()
                this.$emit('end')
              }
            : undefined
        }
        class={[
          'py-2 px-3 rounded text-white my-2 w-xl max-w-full transition-opacity duration-200',
          bg,
          `opacity-${this.opacity}`,
        ]}
      >
        <strong class="font-semibold">{this.alert.title}</strong>
        {this.alert.description && (
          <p class="text-justify">{this.alert.description}</p>
        )}
      </div>
    )
  },
})

export default Alert
