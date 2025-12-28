import { beforeEach, describe, expect, test, vi } from 'vitest'
import { flushPromises, mount } from '@vue/test-utils'
import waitForExpect from 'wait-for-expect'
import { toast } from 'vue-sonner'
import LoginForm from '@/entities/auth/components/forms/LoginForm.vue'

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
  beforeEach(() => {
    vi.clearAllMocks()
  })

  function createWrapper() {
    return mount(LoginForm)
  }

  const wrapper = createWrapper()

  const emailInput = wrapper.find('[data-test="email-input"]')
  const emailErrors = wrapper.find('[data-test="email-errors"]')

  const passwordInput = wrapper.find('[data-test="password-input"]')
  const passwordErrors = wrapper.find('[data-test="password-errors"]')

  async function submitForm(): Promise<void> {
    await wrapper.find('form').trigger('submit')
  }

  test('should succeed on submit', async () => {
    // Arrange
    await emailInput.setValue('test@test.com')
    await passwordInput.setValue('password123')

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
