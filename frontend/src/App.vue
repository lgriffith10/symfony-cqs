<template>
  <VueQueryDevtools />
  <Toaster position="bottom-right" richColors closeButton />

  <div class="flex h-screen w-full">
    <component :is="layout">
      <RouterView />
    </component>
  </div>
</template>

<script setup lang="ts">
import { useLayout } from '@/entities/common/composables/useLayout.ts'
import { Toaster } from 'vue-sonner'
import { VueQueryDevtools } from '@tanstack/vue-query-devtools'

const { layout } = useLayout()
</script>
