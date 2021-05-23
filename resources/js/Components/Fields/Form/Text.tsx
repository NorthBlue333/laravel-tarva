import {defineComponent, PropType, ref} from 'vue'
import {FormInstanciatedField} from "../../../types/resources";
import Field from "./Field";
import {InertiaForm} from "@inertiajs/inertia-vue3";

const Text = defineComponent({
    props: {
        'onValue:updated': {
            type: Function as PropType<(attribute: string, value: string | null) => void>,
            required: true
        },
        field: {
            type: Object as PropType<FormInstanciatedField<any>>,
            required: true
        },
        errors: {
            type: Array as PropType<string[]>,
        },
        value: {
            type: String,
        }
    },
    emits: {
        'value:updated': (attribute: string, value: string | null) => true
    },
    render() {
        return (
            <Field>
                <div class="flex flex-wrap p-3 items-center justify-end">
                    <label for={this.field.attribute}
                           class="text-gray-medium-light w-1/4">
                        {this.field.name}
                        {this.field.isRequired && <span class="text-sm">*</span>}
                    </label>
                    <input class={['w-3/4', this.errors?.length ? 'is-invalid' : null]}
                           value={this.value ?? this.field.value}
                           name={this.field.attribute}
                           id={this.field.attribute}
                           onChange={(e) => this.$emit('value:updated', this.field.attribute, (e.target! as unknown as {value: string}).value)}
                           {...this.field.metadata}
                    />
                    {this.field.helper && <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
                        {this.field.helper}
                    </p>}
                    {(this.errors ?? []).map(error =>(
                        <p class="w-3/4 mt-1 italic text-sm text-red">
                            {error}
                        </p>
                    ))}
                </div>
            </Field>
        )
    },
})

export default Text
