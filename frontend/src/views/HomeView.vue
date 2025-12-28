<template>
  <div>
    <div>{{ isLoading }}</div>
    <div v-if="data">{{ data }}</div>
  </div>
</template>

<script setup lang="ts">
import { useGetTasksQuery } from '@/entities/tasks/composables'

const { data, isLoading } = useGetTasksQuery()
</script>
