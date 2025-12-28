import { useQuery } from '@tanstack/vue-query'
import { getTasks } from '@/entities/tasks/services'

export function useGetTasksQuery() {
  return useQuery({
    queryFn: () => getTasks(),
    queryKey: ['getTasks'],
    retry: false,
  })
}
