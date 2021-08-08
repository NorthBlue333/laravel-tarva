import { defineComponent, PropType, ref } from 'vue'
import { WysiwygInstanciatedField } from '../../../types/resources'
import Field from './Field'
import { Head } from '@inertiajs/inertia-vue3'

const Wysiwyg = defineComponent({
  props: {
    field: {
      type: Object as PropType<WysiwygInstanciatedField<string | null>>,
      required: true,
    },
  },
  setup() {
    return {
      shouldShowText: ref(false),
    }
  },
  render() {
    console.log(
      this.field.additionalCssFiles.map((link) => (
        <link rel="stylesheet" href={link} />
      ))
    )
    return (
      <Field>
        <Head>
          {this.field.additionalCssFiles.map((link) => (
            <link rel="stylesheet" href={link} />
          ))}
        </Head>
        <div class="flex flex-wrap p-3 justify-end">
          <div class="text-gray-medium-light w-1/4">{this.field.name}</div>
          <div class="w-3/4">
            {this.shouldShowText && (
              <div
                v-html={this.field.valueForDisplay}
                data-prosemirror={this.field.attribute}
              ></div>
            )}
            <div>
              <button
                class="text-tertiary font-semibold focus:outline-none"
                onClick={(e) => {
                  e.preventDefault()
                  this.shouldShowText = !this.shouldShowText
                }}
              >
                {this.shouldShowText ? (
                  <span>Cacher le texte</span>
                ) : (
                  <span>Afficher le texte</span>
                )}
              </button>
            </div>
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

export default Wysiwyg
