import { defineComponent, onBeforeUnmount, PropType, ref, watch } from 'vue'
import { WysiwygFormInstanciatedField } from '../../../types/resources'
import Field from './Field'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import { Head } from '@inertiajs/inertia-vue3'
import Highlight from '@tiptap/extension-highlight'
import Link from '@tiptap/extension-link'
import Subscript from '@tiptap/extension-subscript'
import Superscript from '@tiptap/extension-superscript'
import Underline from '@tiptap/extension-underline'

const Wysiwyg = defineComponent({
  components: {
    EditorContent,
  },
  props: {
    'onValue:updated': {
      type: Function as PropType<
        (attribute: string, value: string | null) => void
      >,
      required: true,
    },
    field: {
      type: Object as PropType<WysiwygFormInstanciatedField<string | null>>,
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
    const editor = useEditor({
      content: props.value ?? props.field.value ?? '',
      extensions: [
        StarterKit,
        Highlight,
        Link,
        Subscript,
        Superscript,
        Underline,
      ],
      onTransaction: () => {
        if (editor.value?.getHTML() === props.value) return
        const val = editor.value?.getHTML() ?? null
        emit(
          'value:updated',
          props.field.attribute,
          val === '<p></p>' ? null : val
        )
      },
    })
    onBeforeUnmount(() => editor.value?.destroy())
    return {
      shouldShowHeadingsDropdown: ref(false),
      editor,
    }
  },
  render() {
    console.log(this.field.headings)
    return (
      <Field>
        <Head>
          {this.field.additionalCssFiles.map((link) => (
            <link rel="stylesheet" href={link} />
          ))}
        </Head>
        <div class="flex flex-wrap p-3 items-center justify-end">
          <label
            for={this.field.attribute}
            class="text-gray-medium-light w-1/4"
          >
            {this.field.name}
            {this.field.isRequired && <span class="text-sm">*</span>}
          </label>
          <div
            class={['w-3/4 wysiwyg', this.errors?.length ? 'is-invalid' : null]}
          >
            <div class="mb-2 wysiwyg-menu">
              {this.field.bold && (
                <button
                  class={[
                    'mr-1 wysiwyg-button',
                    this.editor?.isActive('bold') ? 'is-active' : null,
                  ]}
                  onClick={(e) => {
                    e.preventDefault()
                    this.editor?.chain().focus().toggleBold().run()
                  }}
                >
                  <i class="fas fa-bold transition-colors duration-100"></i>
                </button>
              )}
              {this.field.italic && (
                <button
                  class={[
                    'mx-1 wysiwyg-button',
                    this.editor?.isActive('italic') ? 'is-active' : null,
                  ]}
                  onClick={(e) => {
                    e.preventDefault()
                    this.editor?.chain().focus().toggleItalic().run()
                  }}
                >
                  <i class="fas fa-italic transition-colors duration-100"></i>
                </button>
              )}
              {this.field.underline && (
                <button
                  class={[
                    'mx-1 wysiwyg-button',
                    this.editor?.isActive('underline') ? 'is-active' : null,
                  ]}
                  onClick={(e) => {
                    e.preventDefault()
                    this.editor?.chain().focus().toggleUnderline().run()
                  }}
                >
                  <i class="fas fa-underline transition-colors duration-100"></i>
                </button>
              )}
              {this.field.strike && (
                <button
                  class={[
                    'mx-1 wysiwyg-button',
                    this.editor?.isActive('strike') ? 'is-active' : null,
                  ]}
                  onClick={(e) => {
                    e.preventDefault()
                    this.editor?.chain().focus().toggleStrike().run()
                  }}
                >
                  <i class="fas fa-strikethrough transition-colors duration-100"></i>
                </button>
              )}
              {this.field.highlight && (
                <button
                  class={[
                    'mx-1 wysiwyg-button',
                    this.editor?.isActive('highlight') ? 'is-active' : null,
                  ]}
                  onClick={(e) => {
                    e.preventDefault()
                    this.editor?.chain().focus().toggleStrike().run()
                  }}
                >
                  <i class="fas fa-highlighter transition-colors duration-100"></i>
                </button>
              )}
              {!!this.field.headings.length && (
                <div class="relative">
                  <button
                    class={[
                      'mx-1 wysiwyg-button relative',
                      this.editor?.isActive('heading', { level: 1 }) ||
                      this.editor?.isActive('heading', { level: 2 }) ||
                      this.editor?.isActive('heading', { level: 3 }) ||
                      this.editor?.isActive('heading', { level: 4 }) ||
                      this.editor?.isActive('heading', { level: 5 }) ||
                      this.editor?.isActive('heading', { level: 6 })
                        ? 'is-active'
                        : null,
                    ]}
                    onClick={(e) => {
                      e.preventDefault()
                      this.shouldShowHeadingsDropdown =
                        !this.shouldShowHeadingsDropdown
                    }}
                  >
                    <i class="fas fa-heading transition-colors duration-100"></i>
                  </button>
                  {this.shouldShowHeadingsDropdown && (
                    <ul class="absolute wysiwyg-button-dropdown">
                      {this.field.headings.map((heading) => {
                        const level = +heading.replace('h', '')
                        return (
                          <li>
                            <button
                              class={[
                                'wysiwyg-button-dropdown-item',
                                this.editor?.isActive('heading', { level })
                                  ? 'is-active'
                                  : null,
                              ]}
                              onClick={(e) => {
                                e.preventDefault()
                                this.editor
                                  ?.chain()
                                  .focus()
                                  .toggleHeading({
                                    level: level as 1 | 2 | 3 | 4 | 5 | 6,
                                  })
                                  .run()
                                this.shouldShowHeadingsDropdown = false
                              }}
                            >
                              {heading}
                            </button>
                          </li>
                        )
                      })}
                    </ul>
                  )}
                </div>
              )}
              {/*<button class={['mx-1 wysiwyg-button']} onClick={(e) => {*/}
              {/*    e.preventDefault()*/}
              {/*    this.editor?.chain().focus().clearNodes().run()*/}
              {/*}}>*/}
              {/*    <i*/}
              {/*        class="fas fa-ban transition-colors duration-100"*/}
              {/*    ></i>*/}
              {/*</button>*/}
              {/*<button class={['mx-1 wysiwyg-button', this.editor?.isActive('paragraph') ? 'is-active' : null]} onClick={(e) => {*/}
              {/*    e.preventDefault()*/}
              {/*    this.editor?.chain().focus().setParagraph().run()*/}
              {/*}}*/}
              {/*>*/}
              {/*    <i*/}
              {/*        class="fas fa-paragraph transition-colors duration-100"*/}
              {/*    ></i>*/}
              {/*</button>*/}
              <button
                class={[
                  'mx-1 wysiwyg-button',
                  this.editor?.isActive('bulletList') ? 'is-active' : null,
                ]}
                onClick={(e) => {
                  e.preventDefault()
                  this.editor?.chain().focus().toggleBulletList().run()
                }}
              >
                <i class="fas fa-list-ul transition-colors duration-100"></i>
              </button>
              <button
                class={[
                  'mx-1 wysiwyg-button',
                  this.editor?.isActive('orderedList') ? 'is-active' : null,
                ]}
                onClick={(e) => {
                  e.preventDefault()
                  this.editor?.chain().focus().toggleOrderedList().run()
                }}
              >
                <i class="fas fa-list-ol transition-colors duration-100"></i>
              </button>
              {/*<button class={['mx-1 wysiwyg-button']} onClick={(e) => {*/}
              {/*    e.preventDefault()*/}
              {/*    this.editor?.chain().focus().setHorizontalRule().run()*/}
              {/*}}>*/}
              {/*    <i*/}
              {/*        class="fas fa-grip-lines transition-colors duration-100"*/}
              {/*    ></i>*/}
              {/*</button>*/}
              {/*<button class={['mx-1 wysiwyg-button']} onClick={(e) => {*/}
              {/*    e.preventDefault()*/}
              {/*    this.editor?.chain().focus().setHardBreak().run()*/}
              {/*}}>*/}
              {/*    <i*/}
              {/*        class="fas fa-level-down-alt transition-colors duration-100 transform rotate-90"*/}
              {/*    ></i>*/}
              {/*</button>*/}
              <button
                class={['mx-1 wysiwyg-button']}
                onClick={(e) => {
                  e.preventDefault()
                  this.editor?.chain().focus().unsetAllMarks().run()
                  this.editor?.chain().focus().clearNodes().run()
                }}
              >
                <i class="fas fa-ban transition-colors duration-100"></i>
              </button>
              <button
                class={['mx-1 wysiwyg-button']}
                onClick={(e) => {
                  e.preventDefault()
                  this.editor?.chain().focus().undo().run()
                }}
              >
                <i class="fas fa-undo transition-colors duration-100"></i>
              </button>
              <button
                class={['mx-1 wysiwyg-button']}
                onClick={(e) => {
                  e.preventDefault()
                  this.editor?.chain().focus().redo().run()
                }}
              >
                <i class="fas fa-redo transition-colors duration-100"></i>
              </button>
            </div>
            <div class="wysiwyg-editor-content">
              <editor-content
                data-prosemirror={this.field.attribute}
                editor={this.editor}
              />
            </div>
          </div>
          {this.field.helper && (
            <p class="w-3/4 mt-1 italic text-sm text-gray-medium-light">
              {this.field.helper}
            </p>
          )}
          {(this.errors ?? []).map((error) => (
            <p class="w-3/4 mt-1 italic text-sm text-red">{error}</p>
          ))}
        </div>
      </Field>
    )
  },
})

export default Wysiwyg
