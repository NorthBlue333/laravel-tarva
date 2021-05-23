import { defineComponent, h, ref } from 'vue'
import Drawer from '../Components/Drawer'
import Navbar from '../Components/Navbar'

const Base = defineComponent({
    setup() {
        return {
            isOpen: ref(true),
            isLocked: ref(true),
        }
    },
    render() {
        return (
            <div class="z-50 fixed top-0 left-0 h-screen w-screen flex">
                <Drawer
                    onMouse:enter={() => {
                        if (this.isOpen) return
                        this.isOpen = true
                    }}
                    onMouse:leave={() => {
                        if (!this.isOpen || this.isLocked) return
                        this.isOpen = false
                    }}
                    isOpen={this.isOpen}
                />
                <div class="w-full h-full flex-grow overflow-y-auto flex flex-col">
                    <Navbar
                        onArrow:clicked={() => {
                            this.isLocked = !this.isLocked
                            this.isOpen = this.isLocked
                        }}
                        isLocked={this.isLocked}
                    />
                    {this.$slots.default ? this.$slots.default() : null}
                </div>
            </div>
        )
    },
})

export default Base
