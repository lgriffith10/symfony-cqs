import { z } from 'zod'

const LoginRequestSchema = z.object({
  username: z.email(),
  password: z.string()
})

export type LoginRequest = z.infer<typeof LoginRequestSchema>