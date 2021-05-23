import route from 'ziggy-js'

declare module '@vue/runtime-core' {
    export interface ComponentCustomProperties {
        $route: typeof route
    }
}

declare global {
    export namespace Inertia {
        export interface PagePropsBeforeTransform {
            adminResourceClasses: {
                uriKey: string
                singular: string
                plural: string
                icon?: string
            }[]
            user?: {
                id: unknown
                email: string
            }
        }
        export interface PageProps {
            adminResourceClasses: {
                uriKey: string
                singular: string
                plural: string
                icon?: string
            }[]
            user?: {
                id: unknown
                email: string
            }
        }
    }
}
