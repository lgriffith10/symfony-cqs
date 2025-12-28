import { api } from '@/utils/api.ts'
import {
  type RegisterUserRequest,
  type RegisterUserResponse,
  RegisterUserResponseSchema,
} from '@/entities/auth/types/registerUser.ts'
import type { LoginRequest } from '@/entities/auth/types/login.ts'
import { type MeResponse, MeResponseSchema } from '@/entities/auth/types/me.ts'

export async function registerUser(
  request: RegisterUserRequest,
): Promise<RegisterUserResponse | undefined> {
  try {
    const { data } = await api.post('/api/register', request)
    return RegisterUserResponseSchema.parse(data)
  } catch (e: any) {
    throw new Error(e.message)
  }
}

export async function login(request: LoginRequest): Promise<void> {
  try {
    await api.post('/api/login_check', request)
  } catch (e: any) {
    throw new Error(e.message)
  }
}

export async function me(): Promise<MeResponse> {
  try {
    const { data } = await api.get('/api/me')
    return MeResponseSchema.parse(data.data)
  } catch (e: any) {
    throw new Error(e.message)
  }
}
