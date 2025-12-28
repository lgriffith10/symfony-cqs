import { z } from 'zod'

const TaskState = {
  Todo: 'todo',
  Ongoing: 'ongoing',
  Completed: 'completed',
  Deleted: 'deleted',
} as const

export const TaskStateEnum = z.enum(TaskState)
