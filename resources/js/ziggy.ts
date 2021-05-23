import type { default as ziggy } from 'ziggy-js'

export const route = (
    window as unknown as {
        route: typeof ziggy
    }
).route
