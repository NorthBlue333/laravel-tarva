export interface Page {
  name: string
  uriKey: string
  component: string
  icon?: string
  additionalCssFiles: string[]
  additionalJsFiles: string[]
}
