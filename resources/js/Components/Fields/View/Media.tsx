import { defineComponent, PropType } from 'vue'
import { InstanciatedField } from '../../../types/resources'
import { ExistingMedia } from '../Form/Media'
import Field from './Field'

const Media = defineComponent({
  props: {
    field: {
      type: Object as PropType<InstanciatedField<ExistingMedia[]>>,
      required: true,
    },
  },
  render() {
    return (
      <Field>
        <div class="flex flex-wrap p-3 items-center justify-end">
          <div class="text-gray-medium-light w-1/4">{this.field.name}</div>
          <div class="w-3/4 ml-1/4 flex">
            {(this.field.valueForDisplay ?? []).map((media, idx) => (
              <div class={['text-center', idx === 0 ? 'mr-2 my-2 ' : 'm-2']}>
                <picture class="w-48 h-48 flex items-center justify-center shadow rounded border border-tertiary border-opacity-50 relative bg-gray-100">
                  <img
                    class="max-w-full max-h-full"
                    alt={`Preview image ${media.name}`}
                    src={media.fullUrl}
                  />
                </picture>
                <div class="text-gray-medium-light w-48 h-6 group relative">
                  <p class="whitespace-nowrap overflow-ellipsis overflow-hidden">
                    {media.name}
                  </p>
                  <p class="z-20 absolute bg-gray-200 px-2 py-1 rounded whitespace-nowrap shadow left-1/2 top-1/2 transform  -translate-x-1/2 -translate-y-1/2 invisible group-hover:visible">
                    {media.name}
                  </p>
                </div>
              </div>
            ))}
          </div>
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

export default Media
