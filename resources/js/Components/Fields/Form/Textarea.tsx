import { FormInstanciatedField } from 'resources/js/types/resources'
import { defineComponent, PropType, watch } from 'vue'
import Field from './Field'

const Textarea = defineComponent({
  props: {
    'onValue:updated': {
      type: Function as PropType<
        (attribute: string, value: string | null) => void
      >,
      required: true,
    },
    field: {
      type: Object as PropType<FormInstanciatedField<string | null>>,
      required: true,
    },
    errors: {
      type: Array as PropType<string[]>,
    },
    value: {
      type: String,
    },
  },
  emits: {
    'value:updated': (attribute: string, value?: string | null) => true,
  },
  setup(props, { emit }) {
    emit('value:updated', props.field.attribute, props.field.value)
    watch(props, (p, oldProps) => {
      if (p.field.value === oldProps.field.value) return
      emit('value:updated', props.field.attribute, props.field.value)
    })
  },
  render() {
    return (
      <Field>
        <div class="flex flex-wrap p-3">
          <div class="text-gray-medium-light w-1/4">{this.field.name}</div>
          <div class="w-3/4">{this.field.valueForDisplay}</div>
          {!!this.field.helper && <p class="w-full">{this.field.helper}</p>}
        </div>
      </Field>
    )
  },
})

export default Textarea
