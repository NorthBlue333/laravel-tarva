export enum AlertType {
  Success = 'Success',
  Info = 'Info',
  Warning = 'Warning',
  Error = 'Error',
}

export interface IAlert {
  title: string
  description?: string
  type: AlertType
  duration?: number
}
