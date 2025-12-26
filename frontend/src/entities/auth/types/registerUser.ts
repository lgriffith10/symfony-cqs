import { z } from 'zod'

export const RegisterUserRequestSchema = z.object({
  email: z.email(),
  password: z.string(),
})

export type RegisterUserRequest = z.infer<typeof RegisterUserRequestSchema>

export const RegisterUserResponseSchema = z.object({
  id: z.uuid(),
})

export type RegisterUserResponse = z.infer<typeof RegisterUserResponseSchema>
