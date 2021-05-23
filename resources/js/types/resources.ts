export interface FieldOrPanel {
    name: string
    isPanel: boolean
}

export interface InstanciatedFieldOrPanel {
    name: string
    isPanel: boolean
}

export interface Field extends FieldOrPanel {
    //
}

export interface InstanciatedField<T> extends InstanciatedFieldOrPanel {
    value: T
    valueForDisplay: string
    component: string
    helper: string
}

export interface FormInstanciatedField<T> extends InstanciatedField<T> {
    isRequired: boolean
    metadata: {
        [key: string]: string
    }
    attribute: string
}

export interface Panel extends FieldOrPanel {
    fields: Field[]
}

export interface InstanciatedPanel extends InstanciatedFieldOrPanel {
    fields: InstanciatedField<unknown>[]
}

export interface FormInstanciatedPanel extends InstanciatedPanel {
    showTitle: boolean
    fields: FormInstanciatedField<unknown>[]
}

export interface Filter {
    name: string
    type: 'select'
}

export interface SelectFilter<T> extends Filter {
    type: 'select'
    values: T[]
}

export type AnyFilter<SFT> = SelectFilter<SFT>

export interface InstanciatedFilter<T> {
    name: string
    value: T
}

export interface ResourceInstance {
    _id: unknown
    fields: InstanciatedFieldOrPanel[]
}
