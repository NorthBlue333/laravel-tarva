import { defineComponent, PropType, ref, watch } from 'vue'
import Alert from './Alert'
import { IAlert } from './types'

const AlertBar = defineComponent({
  props: {
    alerts: {
      type: Array as PropType<IAlert[]>,
      required: true,
    },
  },
  setup(props) {
    const internalAlerts = ref(props.alerts)
    watch(
      props,
      (value) => {
        internalAlerts.value.push(...value.alerts)
      },
      { deep: true }
    )
    return {
      internalAlerts,
    }
  },
  render() {
    return (
      <div class="z-50 absolute bottom-4 right-12">
        {this.internalAlerts.map((alert) => (
          <Alert
            onEnd={() => {
              const index = this.internalAlerts.indexOf(alert)
              if (index < 0) return
              this.internalAlerts = [
                ...this.internalAlerts.slice(0, index),
                ...this.internalAlerts.slice(index + 1),
              ]
            }}
            shouldHideOnTap={true}
            alert={alert}
          />
        ))}
      </div>
    )
  },
})

export default AlertBar
