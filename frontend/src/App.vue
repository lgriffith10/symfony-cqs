<script setup lang="ts">
import { useLayout } from '@/entities/common/composables/useLayout.ts'

const { layout } = useLayout()
</script>

<template>
  <div class="flex h-screen w-full">
    <component :is="layout">
      <RouterView />
    </component>
  </div>
</template>

<style scoped></style>
