<script setup lang="ts">
import { useLayout } from '@/entities/common/composables/useLayout.ts'
import { Toaster } from 'vue-sonner'

const { layout } = useLayout()
</script>

<template>
  <Toaster position="bottom-right" richColors closeButton />

  <div class="flex h-screen w-full">
    <component :is="layout">
      <RouterView />
    </component>
  </div>
</template>
