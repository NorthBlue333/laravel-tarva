import { defineComponent } from 'vue'

const Field = defineComponent({
    render() {
        return (
            <div class="border-b border-gray-lighter last:border-0">
                {this.$slots.default && this.$slots.default()}
            </div>
        )
    },
})

export default Field
