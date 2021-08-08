import { defineComponent, PropType } from 'vue'
import { InstanciatedField } from '../../../types/resources'
import Field from './Field'

const Textarea = defineComponent({
  props: {
    field: {
      type: Object as PropType<InstanciatedField<any>>,
      required: true,
    },
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
