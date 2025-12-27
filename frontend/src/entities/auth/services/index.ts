import { api } from '@/utils/api.ts'
import {
  type RegisterUserRequest,
  type RegisterUserResponse,
  RegisterUserResponseSchema,
} from '@/entities/auth/types/registerUser.ts'
import type { LoginRequest } from '@/entities/auth/types/login.ts'

export async function registerUser(
  request: RegisterUserRequest,
): Promise<RegisterUserResponse | undefined> {
  try {
    const { data } = await api.post('/api/register', request)
    return RegisterUserResponseSchema.parse(data)
  } catch (e: any) {
    throw new Error(e.response?.data?.detail)
  }
}

export async function login(request: LoginRequest): Promise<void> {
  try {
    await api.post('/api/login_check', request)
  } catch (e: any) {
    throw new Error(e.message)
  }
}
