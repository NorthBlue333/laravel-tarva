export interface BaseFieldOrPanel {
  name: string
  isPanel: boolean
  [key: string]: unknown
}

export interface BaseField extends BaseFieldOrPanel {
  helper?: string
}

export interface BasePanel extends BaseFieldOrPanel {
  showTitle?: boolean
  fields:
    | Field[]
    | InstanciatedField<unknown>[]
    | FormInstanciatedField<unknown>[]
}

export interface Field extends BaseField {
  //
}

export interface InstanciatedField<T> extends BaseField {
  value?: T | null
  valueForDisplay?: T | null
  component: string
  attribute: string
}

export interface FormInstanciatedField<T> extends InstanciatedField<T> {
  isRequired?: boolean
  metadata: Record<string, string | boolean | undefined>
}

export interface Panel extends BasePanel {
  fields: Field[]
}

export interface InstanciatedPanel extends BasePanel {
  fields: InstanciatedField<unknown>[] | FormInstanciatedField<unknown>[]
}

export interface FormInstanciatedPanel extends InstanciatedPanel {
  fields: FormInstanciatedField<unknown>[]
}

export enum FilterTypes {
  select = 'select',
}

export interface Filter {
  name: string
  type: FilterTypes
}

export interface SelectFilter<T> extends Filter {
  type: FilterTypes
  values: T[]
}

export type AnyFilter<SFT> = SelectFilter<SFT>

export interface InstanciatedFilter<T> {
  name: string
  value: T
}

export interface BaseResourceInstance {
  _id: unknown
}

export interface IndexResourceInstance extends BaseResourceInstance {
  fields: (InstanciatedField<unknown> | InstanciatedPanel)[]
}

export interface ShowResourceInstance extends BaseResourceInstance {
  title: string
  panels: (InstanciatedPanel & { showTitle: boolean })[]
}

export interface FormResourceInstance extends BaseResourceInstance {
  title: string
  panels: FormInstanciatedPanel[]
}

export interface ResourceProperties {
  plural: string
  singular: string
  uriKey: string
}

export interface ListResourceProperties extends ResourceProperties {
  totalCount: number
}

export interface WysiwygInstanciatedField<T> extends InstanciatedField<T> {
  additionalCssFiles: string[]
}

export interface WysiwygFormInstanciatedField<T>
  extends FormInstanciatedField<T> {
  additionalCssFiles: string[]
  headings: ('h1' | 'h2' | 'h3' | 'h4' | 'h5' | 'h6')[]
  bold: boolean
  italic: boolean
  strike: boolean
  bulletList: boolean
  orderedList: boolean
  highlight: boolean
  link: boolean
  subscript: boolean
  superscript: boolean
  underline: boolean
}
