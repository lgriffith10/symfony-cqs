<template>
  <form @submit.prevent="onSubmit">
    <FieldSet>
      <FieldGroup>
        <Field>
          <FieldLabel for="email">Email</FieldLabel>
          <Input
            v-model="email"
            v-bind="emailAttrs"
            type="email"
            placeholder="john@doe.com"
            data-test="email-input"
          />
          <FieldError :errors="[errors.email]" data-test="email-errors" />
        </Field>
        <Field>
          <FieldLabel for="password">Password</FieldLabel>
          <Input
            v-model="password"
            v-bind="passwordAttrs"
            type="password"
            placeholder="password"
            data-test="password-input"
          />
          <FieldError :errors="[errors.password]" data-test="password-errors" />
        </Field>

        <Field>
          <FieldLabel for="password">Confirm password</FieldLabel>
          <Input
            v-model="confirmPassword"
            v-bind="confirmPasswordAttrs"
            type="password"
            placeholder="password"
            data-test="confirm-password-input"
          />
          <FieldError :errors="[errors.confirmPassword]" data-test="confirm-password-errors" />
        </Field>

        <Field>
          <Button type="submit" variant="default">Sign up</Button>
        </Field>
      </FieldGroup>
    </FieldSet>
  </form>
</template>

<script setup lang="ts">
import { toTypedSchema } from '@vee-validate/zod'
import { z } from 'zod'
import { useForm } from 'vee-validate'
import { Field, FieldError, FieldGroup, FieldLabel, FieldSet } from '@/components/ui/field'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { useRegisterMutation } from '@/entities/auth/composables'
import { toast } from 'vue-sonner'

const { mutateAsync } = useRegisterMutation()

const validationSchema = toTypedSchema(
  z
    .object({
      email: z.email(),
      password: z.string().min(6, 'Must be at least 6 characters'),
      confirmPassword: z.string(),
    })
    .refine((data) => data.password === data.confirmPassword, {
      message: 'Passwords should have same value',
      path: ['confirmPassword'],
    }),
)

const { errors, defineField, handleSubmit } = useForm({
  validationSchema,
  initialValues: {
    email: '',
    password: '',
    confirmPassword: '',
  },
})

const [email, emailAttrs] = defineField('email')
const [password, passwordAttrs] = defineField('password')
const [confirmPassword, confirmPasswordAttrs] = defineField('confirmPassword')

const onSubmit = handleSubmit(async ({ email, password }) => {
  try {
    await mutateAsync({
      email,
      password,
    })
    toast.success('You were successfully registered. Please login.')
  } catch (error: any) {
    toast.error(error.message)
  }
})
</script>
