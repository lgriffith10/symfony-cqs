import { beforeEach, describe, expect, test, vi } from 'vitest'
import RegisterForm from '@/entities/auth/components/forms/RegisterForm.vue'
import { flushPromises, mount } from '@vue/test-utils'
import { toast } from 'vue-sonner'
import waitForExpect from 'wait-for-expect'

const mutateAsyncMock = vi.fn()
vi.mock('@/entities/auth/composables', () => ({
  useRegisterMutation: () => ({
    mutateAsync: mutateAsyncMock,
  }),
}))

vi.mock('vue-sonner', () => ({
  toast: {
    success: vi.fn(),
    error: vi.fn(),
  },
}))

describe('RegisterForm', () => {
  beforeEach(() => {
    vi.clearAllMocks()
  })

  function createWrapper() {
    return mount(RegisterForm)
  }

  const wrapper = createWrapper()

  const emailInput = wrapper.find('[data-test="email-input"]')
  const passwordInput = wrapper.find('[data-test="password-input"]')
  const confirmPasswordInput = wrapper.find('[data-test="confirm-password-input"]')

  async function submitForm() {
    await wrapper.find('form').trigger('submit')
  }

  test('should succeed on submit', async () => {
    // Arrange
    await emailInput.setValue('test@test.com')
    await passwordInput.setValue('password123')
    await confirmPasswordInput.setValue('password123')

    // Act
    await submitForm()
    await flushPromises()

    // Assert
    await waitForExpect(() => {
      expect(mutateAsyncMock).toHaveBeenCalledWith({
        email: 'test@test.com',
        password: 'password123',
      })
      expect(toast.success).toHaveBeenCalledWith('You were successfully registered. Please login.')
    })
  })

  test('should called toast.error on api error', async () => {
    // Arrange
    await emailInput.setValue('test@test.com')
    await passwordInput.setValue('password123')
    await confirmPasswordInput.setValue('password123')

    // Act
    await submitForm()
    await flushPromises()

    mutateAsyncMock.mockRejectedValue(new Error('ErrorMessage'))

    // Assert
    await waitForExpect(() => {
      expect(mutateAsyncMock).toHaveBeenCalledWith({
        email: 'test@test.com',
        password: 'password123',
      })
      expect(toast.error).toHaveBeenCalledWith('ErrorMessage')
    })
  })

  test('should fail with invalid email', async () => {
    // Arrange
    await emailInput.setValue('wrong-email')
    await passwordInput.setValue('password123')
    await confirmPasswordInput.setValue('password123')

    const emailErrors = wrapper.find('[data-test="email-errors"]')

    // Act
    await submitForm()
    await flushPromises()

    // Assert
    await waitForExpect(() => {
      expect(emailErrors.text()).toContain('Invalid email address')
      expect(mutateAsyncMock).not.toHaveBeenCalled()
    })
  })

  test('should fail with short password', async () => {
    // Arrange
    await emailInput.setValue('email@test.com')
    await passwordInput.setValue('test')

    const passwordErrors = wrapper.find('[data-test="password-errors"]')

    // Act
    await submitForm()
    await flushPromises()

    // Assert
    await waitForExpect(() => {
      expect(passwordErrors.text()).toContain('Must be at least 6 characters')
      expect(mutateAsyncMock).not.toHaveBeenCalled()
    })
  })

  test('should fail with wrong password confirmation', async () => {
    // Arrange
    await emailInput.setValue('email@test.com')
    await passwordInput.setValue('password123')
    await confirmPasswordInput.setValue('password1234')

    const confirmPasswordErrors = wrapper.find('[data-test="confirm-password-errors"]')

    // Act
    await submitForm()
    await flushPromises()

    // Assert
    await waitForExpect(() => {
      expect(confirmPasswordErrors.text()).toContain('Passwords should have same value')
      expect(mutateAsyncMock).not.toHaveBeenCalled()
    })
  })
})
