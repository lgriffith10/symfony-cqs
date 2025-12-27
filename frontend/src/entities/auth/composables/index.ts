import { useMutation } from '@tanstack/vue-query'
import { login, registerUser } from '@/entities/auth/services'

export function useRegisterMutation() {
  return useMutation({
    mutationFn: registerUser,
    mutationKey: ['registerUserMutation'],
  })
}

export function useLoginMutation() {
  return useMutation({
    mutationFn: login,
    mutationKey: ['loginMutation'],
  })
}
