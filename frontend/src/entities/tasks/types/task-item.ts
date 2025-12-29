import { z } from 'zod'
import { TaskStateEnum } from '@/entities/tasks/types/state-enum.ts'

export const TaskItemSchema = z.object({
  id: z.uuid(),
  name: z.string(),
  state: TaskStateEnum,
  expectedAt: z.object({
    date: z.string(),
    timezone: z.string(),
  }),
})

export type TaskItem = z.infer<typeof TaskItemSchema>
