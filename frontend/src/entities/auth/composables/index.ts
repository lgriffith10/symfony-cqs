import { useMutation } from '@tanstack/vue-query'
import { registerUser } from '@/entities/auth/services'

export function useRegisterMutation() {
  return useMutation({
    mutationFn: registerUser,
    mutationKey: ['registerUserMutation'],
  })
}
