import { createHeadManager, Inertia, Page } from '@inertiajs/inertia'
import route from 'ziggy-js'
import { IAlert } from '../Components/AlertBus/types'

declare module '@vue/runtime-core' {
  export interface ComponentCustomProperties {
    $route: typeof route
    $inertia: typeof Inertia
    $page: Page
    $headManager: ReturnType<typeof createHeadManager>
  }
  export interface ComponentCustomOptions {
    remember?:
      | string
      | string[]
      | {
          data: string | string[]
          key?: string | (() => string)
        }
  }
}
declare module '@inertiajs/inertia' {
  export interface PageProps {
    tarvaResourceClasses: {
      uriKey: string
      singular: string
      plural: string
      icon?: string
    }[]
    tarvaPageClasses: {
      uriKey: string
      name: string
      icon?: string
    }[]
    user?: {
      id: unknown
      email: string
    }
    flash?: {
      ['laravel-tarva--flash-messages']?: {
        alerts: IAlert[]
      } & Record<string, unknown>
    }
  }
}
