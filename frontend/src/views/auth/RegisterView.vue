<template>
  <Card class="w-card">
    <CardHeader>
      <CardTitle>Register yourself</CardTitle>
      <CardDescription>Start planning your everyday life</CardDescription>
      <CardAction>
        <RouterLink :to="{ name: 'Login' }">
          <Button variant="link"> Sign up </Button>
        </RouterLink>
      </CardAction>
    </CardHeader>
    <CardContent>
      <RegisterForm />
    </CardContent>
  </Card>
</template>

<script setup lang="ts">
import RegisterForm from '@/entities/auth/components/forms/RegisterForm.vue'
import {
  Card,
  CardAction,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Button } from '@/components/ui/button'
</script>
