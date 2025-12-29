import { z } from 'zod'
import { TaskItemSchema } from '@/entities/tasks/types/task-item.ts'

export const GetTasksResponseSchema = z.object({
  tasks: TaskItemSchema.array(),
})

export type GetTasksResponse = z.infer<typeof GetTasksResponseSchema>
