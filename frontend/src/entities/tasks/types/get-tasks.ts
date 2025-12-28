import { z } from 'zod'
import { TaskStateEnum } from '@/entities/tasks/types/state-enum.ts'

export const GetTasksResponseSchema = z.object({
  tasks: z
    .object({
      id: z.uuid(),
      name: z.string(),
      state: TaskStateEnum,
      expectedAt: z.object({
        date: z.string(),
        timezone: z.string(),
      }),
    })
    .array(),
})

export type GetTasksResponse = z.infer<typeof GetTasksResponseSchema>
