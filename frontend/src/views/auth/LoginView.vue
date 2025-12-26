<template>
  <Card class="w-card">
    <CardHeader>
      <CardTitle>Sign in</CardTitle>
      <CardDescription> Manage your tasks easily </CardDescription>
      <CardAction>
        <RouterLink :to="{ name: 'Register' }">
          <Button variant="link"> Register </Button>
        </RouterLink>
      </CardAction>
    </CardHeader>
    <CardContent>
      <LoginForm />
    </CardContent>
  </Card>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Card,
  CardAction,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import LoginForm from '@/entities/auth/components/forms/LoginForm.vue'
</script>
