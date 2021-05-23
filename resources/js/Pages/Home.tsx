import { defineComponent, Teleport } from 'vue'
import Base from '../Layouts/Base'

const Home = defineComponent({
    layout: Base,
    render() {
        return (
            <div class="p-4">
                <Teleport to="title">Admin</Teleport>
                This is your admin panel. You can navigate through it with the
                drawer on the left.
            </div>
        )
    },
})

export default Home
