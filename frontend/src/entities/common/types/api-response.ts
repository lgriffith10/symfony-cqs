export type ApiResponse<T extends Record<string, any>> = {
  success: boolean
  data: T
  error: string
  statusCode: number
}
