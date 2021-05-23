import { defineComponent, PropType } from 'vue'

const Navbar = defineComponent({
    props: {
        'onArrow:clicked': {
            type: Function as PropType<() => void>,
        },
        isLocked: {
            type: Boolean,
            required: true,
        },
    },
    emits: {
        'arrow:clicked': () => true,
        arrow: () => true,
    },
    setup(_props, { emit }) {
        return {
            onArrowClick: () => {
                emit('arrow:clicked')
                emit('arrow')
            },
        }
    },
    render() {
        return (
            <div class="w-full h-12 bg-gray-lighter text-gray-dark p-3 flex items-center">
                <button
                    class="px-2 focus:outline-none"
                    onClick={this.onArrowClick}
                >
                    <i
                        class={[
                            'fas fa-arrow-right transition-transform duration-300 transform',
                            this.isLocked ? 'rotate-180' : null,
                        ]}
                    ></i>
                </button>
            </div>
        )
    },
})

export default Navbar
