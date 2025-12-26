import { api } from '@/utils/api.ts'
import {
  type RegisterUserRequest,
  type RegisterUserResponse,
  RegisterUserResponseSchema,
} from '@/entities/auth/types/registerUser.ts'

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
