import { beforeEach, describe, expect, test, vi } from 'vitest'
import { flushPromises, mount } from '@vue/test-utils'
import waitForExpect from 'wait-for-expect'
import { toast } from 'vue-sonner'
import LoginForm from '@/entities/auth/components/forms/LoginForm.vue'
import { useAuthStore } from '@/entities/auth/stores/auth-store.ts'
import { createTestingPinia } from '@pinia/testing'

const mutateAsyncMock = vi.fn()
vi.mock('@/entities/auth/composables', () => ({
  useLoginMutation: () => ({
    mutateAsync: mutateAsyncMock,
  }),
}))

vi.mock('vue-sonner', () => ({
  toast: {
    success: vi.fn(),
    error: vi.fn(),
  },
}))

describe('LoginForm', () => {
  let wrapper: ReturnType<typeof mount>
  let store: ReturnType<typeof useAuthStore>
  let emailInput: any
  let emailErrors: any
  let passwordInput: any
  let passwordErrors: any

  beforeEach(() => {
    vi.clearAllMocks()

    wrapper = mount(LoginForm, {
      global: {
        plugins: [createTestingPinia({ createSpy: vi.fn })],
      },
    })
    emailInput = wrapper.find('[data-test="email-input"]')
    emailErrors = wrapper.find('[data-test="email-errors"]')

    passwordInput = wrapper.find('[data-test="password-input"]')
    passwordErrors = wrapper.find('[data-test="password-errors"]')
  })

  async function submitForm(): Promise<void> {
    await wrapper.find('form').trigger('submit')
  }

  test('should succeed on submit', async () => {
    // Arrange
    await emailInput.setValue('test@test.com')
    await passwordInput.setValue('password123')
    const store = useAuthStore()

    // Act
    await submitForm()
    await flushPromises()

    // Assert
    await waitForExpect(() => {
      expect(mutateAsyncMock).toHaveBeenCalledWith({
        username: 'test@test.com',
        password: 'password123',
      })
      expect(toast.success).toHaveBeenCalledWith('You were successfully logged in.')
      expect(store.setIsAuthenticated).toHaveBeenCalledWith(true)
    })
  })

  test('should fail with incorrect email', async () => {
    // Arrange
    await emailInput.setValue('test.com')
    await passwordInput.setValue('password123')

    // Act
    await submitForm()
    await flushPromises()

    // Assert
    await waitForExpect(() => {
      expect(mutateAsyncMock).not.toHaveBeenCalled()
      expect(emailErrors.text()).toContain('Invalid email address')
    })
  })

  test('should fail with short password', async () => {
    // Arrange
    await emailInput.setValue('test@test.com')
    await passwordInput.setValue('test')

    // Act
    await submitForm()
    await flushPromises()

    // Assert
    await waitForExpect(() => {
      expect(mutateAsyncMock).not.toHaveBeenCalled()
      expect(passwordErrors.text()).toContain('Must be at least 6 characters')
    })
  })

  test('should display toast error on api error', async () => {
    // Arrange
    await emailInput.setValue('test@test.com')
    await passwordInput.setValue('password123')

    // Act
    await submitForm()
    await flushPromises()

    mutateAsyncMock.mockRejectedValue(new Error('ErrorMessage'))

    // Assert
    await waitForExpect(() => {
      expect(mutateAsyncMock).toHaveBeenCalledWith({
        username: 'test@test.com',
        password: 'password123',
      })
      expect(toast.error).toHaveBeenCalledWith('ErrorMessage')
    })
  })
})
