import {defineComponent, PropType, ref} from 'vue'
import {InstanciatedField} from "../../../types/resources";
import Field from "./Field";

const Wysiwyg = defineComponent({
    props: {
        field: {
            type: Object as PropType<InstanciatedField<any>>,
            required: true
        }
    },
    setup() {
        return {
            shouldShowText: ref(false)
        }
    },
    render() {
        return (
            <Field>
                <div class="flex flex-wrap p-3 justify-end">
                    <div class="text-gray-medium-light w-1/4">
                        {this.field.name}
                    </div>
                    <div class="w-3/4" x-data="{shouldShowText: false}">
                        {this.shouldShowText && <div v-html={this.field.valueForDisplay} x-show="shouldShowText"></div>}
                        <div>
                            <button class="text-tertiary font-semibold focus:outline-none" onClick={(e) => {
                                e.preventDefault()
                                this.shouldShowText = !this.shouldShowText
                            }}>
                                {this.shouldShowText ? <span>Cacher le texte</span> : <span>Afficher le texte</span>}
                            </button>
                        </div>
                    </div>
                    {this.field.helper && <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
                        {this.field.helper}
                    </p>}
                </div>
            </Field>
        )
    },
})

export default Wysiwyg
