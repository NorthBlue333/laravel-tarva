import { defineComponent, PropType } from 'vue'
import { InstanciatedField } from '../../../types/resources'
import Field from './Field'

const Text = defineComponent({
  props: {
    field: {
      type: Object as PropType<InstanciatedField<any>>,
      required: true,
    },
  },
  render() {
    return (
      <Field>
        <div class="flex flex-wrap p-3 items-center justify-end">
          <div class="text-gray-medium-light w-1/4">{this.field.name}</div>
          <div class="w-3/4">{this.field.valueForDisplay}</div>
          {!!this.field.helper && (
            <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
              {this.field.helper}
            </p>
          )}
        </div>
      </Field>
    )
  },
})

export default Text
