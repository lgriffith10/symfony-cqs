import { useRoute } from 'vue-router'
import { computed } from 'vue'

export function useLayout() {
  const route = useRoute()

  const layout = computed<string>(() => {
    return route.meta?.layout?.toString() ?? 'BaseLayout'
  })

  return {
    layout,
  }
}
