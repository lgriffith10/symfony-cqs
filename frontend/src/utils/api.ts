import axios, { type AxiosError, type AxiosResponse } from 'axios'
import type { ApiResponse } from '@/entities/common/types/api-response.ts'

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL as string,
  withCredentials: true,
})

api.interceptors.response.use(
  function onFulfilled(response: AxiosResponse<ApiResponse<Record<string, any>>>) {
    return response
  },
  function onRejected(error: AxiosError<ApiResponse<Record<string, any>>>) {
    return Promise.reject(error.response?.data.error)
  },
)
