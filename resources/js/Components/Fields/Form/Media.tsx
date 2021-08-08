import { defineComponent, PropType, ref, watch } from 'vue'
import { FormInstanciatedField } from '../../../types/resources'
import Field from './Field'

export interface ExistingMedia {
  fullUrl: string
  name: string
  key: unknown
}

const Media = defineComponent({
  props: {
    'onValue:updated': {
      type: Function as PropType<
        (attribute: string, value: File | File[] | unknown[] | null) => void
      >,
      required: true,
    },
    field: {
      type: Object as PropType<FormInstanciatedField<ExistingMedia[]>>,
      required: true,
    },
    errors: {
      type: Array as PropType<string[]>,
    },
    value: {
      type: Object as PropType<File[] | File>,
    },
  },
  emits: {
    'value:updated': (
      attribute: string,
      value: File | File[] | unknown[] | null
    ) => true,
  },
  setup(props, { emit }) {
    const existingMedias = ref<ExistingMedia[]>([])
    const deletedMedias = ref<ExistingMedia[]>([])
    const clearInput = () => {
      document
        .querySelectorAll(
          `input#${props.field.attribute}[type="file"][data-media-field-reference="${props.field.attribute}"]`
        )
        .forEach((input) => {
          ;(input as unknown as { value: string }).value = ''
        })
    }
    const reset = (soft = true) => {
      existingMedias.value = props.field.value ?? []
      deletedMedias.value = []
      emit(
        'value:updated',
        `existing-${props.field.attribute}`,
        (props.field.value ?? []).map((media) => media.key)
      )
      if (soft) return
      emit('value:updated', props.field.attribute, null)
      clearInput()
    }
    reset()

    watch(props, (p, oldProps) => {
      if (!p.field.value && !oldProps.field.value) return
      const newValue = p.field.value ?? []
      const oldValue = oldProps.field.value ?? []
      if (
        newValue.reduce(
          (acc, newMedia) =>
            acc &&
            oldValue.findIndex((media) => media.key === newMedia.key) >= 0 &&
            newValue.length === oldProps.field.value?.length,
          true
        )
      )
        return

      reset(false)
    })
    return {
      existingMedias,
      deletedMedias,
      deleteMedia(media: ExistingMedia) {
        const index = existingMedias.value.findIndex(
          (existing) => existing.key === media.key
        )
        if (index < 0) return

        deletedMedias.value.push(media)
        existingMedias.value = [
          ...existingMedias.value.slice(0, index),
          ...existingMedias.value.slice(index + 1),
        ]
        emit(
          'value:updated',
          `existing-${props.field.attribute}`,
          existingMedias.value.map((media) => media.key)
        )
      },
      restoreMedia(media: ExistingMedia) {
        const index = deletedMedias.value.findIndex(
          (deleted) => deleted.key === media.key
        )
        if (index < 0) return

        existingMedias.value.push(media)
        deletedMedias.value = [
          ...deletedMedias.value.slice(0, index),
          ...deletedMedias.value.slice(index + 1),
        ]
        emit(
          'value:updated',
          `existing-${props.field.attribute}`,
          existingMedias.value.map((media) => media.key)
        )
      },
      clearInput,
    }
  },
  render() {
    let value: File[] = []
    if (this.value) {
      value = Array.isArray(this.value) ? this.value : [this.value]
    }
    return (
      <Field>
        <div class="flex flex-wrap p-3 items-center justify-end">
          <label
            for={this.field.attribute}
            class="text-gray-medium-light w-1/4"
          >
            {this.field.name}
            {this.field.isRequired && <span class="text-sm">*</span>}
          </label>
          <div class="w-3/4 mb-1">
            <input
              name={this.field.attribute}
              id={this.field.attribute}
              data-media-field-reference={this.field.attribute}
              onChange={(e) => {
                const files = (e.target! as unknown as { files: FileList })
                  .files
                if (this.field.metadata.multiple) {
                  this.$emit('value:updated', this.field.attribute, [...files])
                  return
                }
                this.$emit('value:updated', this.field.attribute, files[0])
                for (const media of this.existingMedias) {
                  this.deleteMedia(media)
                }
              }}
              type="file"
              {...this.field.metadata}
            />
            <label
              class={[
                'cursor-pointer file-label',
                this.errors?.length ? 'is-invalid' : undefined,
              ]}
              for={this.field.attribute}
            >
              Choose file(s)...
            </label>
          </div>
          {(this.errors ?? []).map((error) => (
            <p class="w-3/4 mt-1 italic text-sm text-red">{error}</p>
          ))}
          <div class="w-3/4 ml-1/4 flex">
            {value.map((media, idx) => (
              <div class={['text-center', idx === 0 ? 'mr-2 my-2 ' : 'm-2']}>
                <picture class="w-48 h-48 flex items-center justify-center shadow rounded border border-tertiary border-opacity-50 relative bg-gray-100">
                  <img
                    class="max-w-full max-h-full"
                    alt={`Preview image ${media.name}`}
                    src={URL.createObjectURL(media)}
                  />
                  <div class="absolute top-2 right-2 bg-tertiary text-white font-bold rounded p-2 uppercase">
                    NEW
                  </div>
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
            {this.existingMedias.map((media, idx) => (
              <div
                class={[
                  'text-center',
                  idx === 0 && !value.length ? 'mr-2 my-2' : 'm-2',
                ]}
              >
                <picture class="w-48 h-48 flex items-center justify-center shadow rounded border border-tertiary border-opacity-50 relative bg-gray-100">
                  <img
                    class="max-w-full max-h-full"
                    alt={`Preview image ${media.name}`}
                    src={media.fullUrl}
                  />
                  <div class="absolute top-0 left-0 w-full h-full bg-gray-medium opacity-0 hover:opacity-100 bg-opacity-25 transition-opacity duration-200">
                    <div class="flex justify-end items-center p-2">
                      <button
                        class="text-tertiary"
                        onClick={(e) => {
                          e.preventDefault()
                          this.deleteMedia(media)
                        }}
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </div>
                </picture>
                <div class="text-gray-medium-light w-48 h-6 group relative">
                  <p class="whitespace-nowrap overflow-ellipsis overflow-hidden">
                    {media.name}
                  </p>
                  <p class="z-20 absolute bg-gray-200 px-2 py-1 rounded whitespace-nowrap shadow left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 invisible group-hover:visible">
                    {media.name}
                  </p>
                </div>
              </div>
            ))}
            {this.deletedMedias.map((media, idx) => (
              <div
                class={[
                  'text-center filter grayscale',
                  idx === 0 && !value.length && !this.existingMedias.length
                    ? 'mr-2 my-2'
                    : 'm-2',
                ]}
              >
                <picture class="w-48 h-48 flex items-center justify-center shadow rounded border border-tertiary border-opacity-50 relative bg-gray-100">
                  <img
                    class="max-w-full max-h-full"
                    alt={`Preview image ${media.name}`}
                    src={media.fullUrl}
                  />
                  <div class="absolute top-0 left-0 w-full h-full bg-gray-medium opacity-50 hover:opacity-100 bg-opacity-25 transition-opacity duration-200">
                    <div class="flex justify-end items-center p-2">
                      <button
                        class="text-secondary"
                        onClick={(e) => {
                          e.preventDefault()
                          if (this.field.metadata.multiple) {
                            this.restoreMedia(media)
                            return
                          }

                          for (const media of this.existingMedias) {
                            this.deleteMedia(media)
                          }
                          this.$emit(
                            'value:updated',
                            this.field.attribute,
                            null
                          )
                          this.clearInput()
                          this.restoreMedia(media)
                        }}
                      >
                        <i class="fas fa-trash-restore"></i>
                      </button>
                    </div>
                  </div>
                </picture>
                <div class="text-gray-medium-light w-48 h-6 group relative">
                  <p class="whitespace-nowrap overflow-ellipsis overflow-hidden">
                    {media.name} <i class="text-xs">(deleted)</i>
                  </p>
                  <p class="z-20 absolute bg-gray-200 px-2 py-1 rounded whitespace-nowrap shadow left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 invisible group-hover:visible">
                    {media.name} <i class="text-xs">(deleted)</i>
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
