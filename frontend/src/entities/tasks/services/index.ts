import { type GetTasksResponse, GetTasksResponseSchema } from '@/entities/tasks/types/get-tasks.ts'
import { api } from '@/utils/api.ts'

export async function getTasks(): Promise<GetTasksResponse> {
  try {
    const { data } = await api.get('/api/tasks')
    return GetTasksResponseSchema.parse(data.data)
  } catch (e: any) {
    console.log({ e })
    throw new Error(e.message)
  }
}
