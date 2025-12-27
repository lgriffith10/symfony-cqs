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
          <FieldError :errors="[errors.email]" />
        </Field>
        <Field>
          <FieldLabel for="password">Password</FieldLabel>
          <Input v-model="password" v-bind="passwordAttrs" type="password" placeholder="password" />
          <FieldError :errors="[errors.password]" />
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
import { useLoginMutation } from '@/entities/auth/composables'
import { toast } from 'vue-sonner'

const { mutateAsync } = useLoginMutation()

const validationSchema = toTypedSchema(
  z.object({
    email: z.email(),
    password: z.string().min(6, 'Must be at least 6 characters'),
  }),
)

const { errors, defineField, handleSubmit } = useForm({
  validationSchema,
  initialValues: {
    email: '',
    password: '',
  },
})

const [email, emailAttrs] = defineField('email')
const [password, passwordAttrs] = defineField('password')

const onSubmit = handleSubmit(async ({ email, password }) => {
  try {
    await mutateAsync({
      username: email,
      password,
    })
    toast.success('You were successfully logged in.')
  } catch (error: any) {
    toast.error(error.message)
  }
})
</script>
