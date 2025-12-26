import { describe, expect, it, vi } from 'vitest'
import { useLayout } from '@/entities/common/composables/useLayout.ts'
import { useRoute } from 'vue-router'

// Mock de vue-router
vi.mock('vue-router', () => ({
  useRoute: vi.fn(),
}))

describe('useLayout', () => {
  it('returns layout from route meta', () => {
    // Arrange
    ;(useRoute as any).mockReturnValue({
      meta: {
        layout: 'AdminLayout',
      },
    })

    // Act
    const { layout } = useLayout()

    // Assert
    expect(layout.value).toBe('AdminLayout')
  })

  it('returns BaseLayout when no layout is defined', () => {
    // Arrange
    ;(useRoute as any).mockReturnValue({
      meta: {},
    })

    // Act
    const { layout } = useLayout()

    // Assert
    expect(layout.value).toBe('BaseLayout')
  })

  it('returns BaseLayout when meta is undefined', () => {
    // Arrange
    ;(useRoute as any).mockReturnValue({})

    // Act
    const { layout } = useLayout()

    // Assert
    expect(layout.value).toBe('BaseLayout')
  })
})
