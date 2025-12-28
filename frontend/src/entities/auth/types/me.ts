import { z } from 'zod'

export const MeResponseSchema = z.object({
  email: z.email(),
})

export type MeResponse = z.infer<typeof MeResponseSchema>
