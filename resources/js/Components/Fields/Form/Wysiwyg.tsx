import {defineComponent, onBeforeUnmount, onUpdated, PropType, ref, watch} from 'vue'
import {FormInstanciatedField, InstanciatedField} from "../../../types/resources";
import Field from "./Field";
import {useEditor, EditorContent} from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import {useForm} from "@inertiajs/inertia-vue3";

const Wysiwyg = defineComponent({
    components: {
        EditorContent,
    },
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
    setup(props, { emit }) {
        const editor = useEditor({
            content: props.value ?? '',
            extensions: [
                StarterKit,
            ],
            onTransaction: () => {
                if(editor.value?.getHTML() === props.value) return;
                const val = editor.value?.getHTML() ?? null
                emit('value:updated', props.field.attribute, val === '<p></p>' ? null : val)
            },
        })
        onBeforeUnmount(() => editor.value?.destroy())
        return {
            shouldShowText: ref(false),
            editor,
        }
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
                    <div
                        class={['w-3/4 wysiwyg', this.errors?.length ? 'is-invalid' : null]}
                    >
                        <div class="mb-2 wysiwyg-menu">
                            <button class={['py-2 px-3 mr-1 rounded shadow bg-gray-100', this.editor?.isActive('bold') ? 'is-active' : null]} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().toggleBold().run()
                            }}
                            >
                                <i
                                    class="fas fa-bold transition-colors duration-100"
                                ></i>
                            </button>
                            <button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100', this.editor?.isActive('italic') ? 'is-active' : null]} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().toggleItalic().run()
                            }}
                            >
                                <i
                                    class="fas fa-italic transition-colors duration-100"
                                ></i>
                            </button>
                            {/*<button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100', this.editor?.isActive('strike') ? 'is-active' : null]} onClick={(e) => {*/}
                            {/*    e.preventDefault()*/}
                            {/*    this.editor?.chain().focus().toggleUnderline().run()*/}
                            {/*}}*/}
                            {/*>*/}
                            {/*    <i*/}
                            {/*        class="fas fa-underline transition-colors duration-100"*/}
                            {/*    ></i>*/}
                            {/*</button>*/}
                            <button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100', this.editor?.isActive('strike') ? 'is-active' : null]} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().toggleStrike().run()
                            }}
                            >
                                <i
                                    class="fas fa-strikethrough transition-colors duration-100"
                                ></i>
                            </button>
                            <button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100', this.editor?.isActive('heading', { level: 3 }) ? 'is-active' : null]} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().toggleHeading({ level: 3 }).run()
                            }}>
                                <i
                                    class="fas fa-heading transition-colors duration-100"
                                ></i>
                            </button>
                            {/*<button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100']} onClick={(e) => {*/}
                            {/*    e.preventDefault()*/}
                            {/*    this.editor?.chain().focus().clearNodes().run()*/}
                            {/*}}>*/}
                            {/*    <i*/}
                            {/*        class="fas fa-ban transition-colors duration-100"*/}
                            {/*    ></i>*/}
                            {/*</button>*/}
                            {/*<button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100', this.editor?.isActive('paragraph') ? 'is-active' : null]} onClick={(e) => {*/}
                            {/*    e.preventDefault()*/}
                            {/*    this.editor?.chain().focus().setParagraph().run()*/}
                            {/*}}*/}
                            {/*>*/}
                            {/*    <i*/}
                            {/*        class="fas fa-paragraph transition-colors duration-100"*/}
                            {/*    ></i>*/}
                            {/*</button>*/}
                            <button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100', this.editor?.isActive('bulletList') ? 'is-active' : null]} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().toggleBulletList().run()
                            }}
                            >
                                <i
                                    class="fas fa-list-ul transition-colors duration-100"
                                ></i>
                            </button>
                            <button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100', this.editor?.isActive('orderedList') ? 'is-active' : null]} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().toggleOrderedList().run()
                            }}
                            >
                                <i
                                    class="fas fa-list-ol transition-colors duration-100"
                                ></i>
                            </button>
                            {/*<button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100']} onClick={(e) => {*/}
                            {/*    e.preventDefault()*/}
                            {/*    this.editor?.chain().focus().setHorizontalRule().run()*/}
                            {/*}}>*/}
                            {/*    <i*/}
                            {/*        class="fas fa-grip-lines transition-colors duration-100"*/}
                            {/*    ></i>*/}
                            {/*</button>*/}
                            {/*<button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100']} onClick={(e) => {*/}
                            {/*    e.preventDefault()*/}
                            {/*    this.editor?.chain().focus().setHardBreak().run()*/}
                            {/*}}>*/}
                            {/*    <i*/}
                            {/*        class="fas fa-level-down-alt transition-colors duration-100 transform rotate-90"*/}
                            {/*    ></i>*/}
                            {/*</button>*/}
                            <button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100']} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().unsetAllMarks().run()
                                this.editor?.chain().focus().clearNodes().run()
                            }}>
                                <i
                                    class="fas fa-ban transition-colors duration-100"
                                ></i>
                            </button>
                            <button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100']} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().undo().run()
                            }}>
                                <i
                                    class="fas fa-undo transition-colors duration-100"
                                ></i>
                            </button>
                            <button class={['py-2 px-3 mx-1 rounded shadow bg-gray-100']} onClick={(e) => {
                                e.preventDefault()
                                this.editor?.chain().focus().redo().run()
                            }}>
                                <i
                                    class="fas fa-redo transition-colors duration-100"
                                ></i>
                            </button>
                        </div>
                        <editor-content editor={this.editor}/>
                    </div>
                    {this.field.helper && <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
                        {this.field.helper}
                    </p>}
                    {(this.errors ?? []).map(error => (
                        <p class="w-3/4 mt-1 italic text-sm text-red">
                            {error}
                        </p>
                    ))}
                </div>
            </Field>
        )
    },
})

export default Wysiwyg
