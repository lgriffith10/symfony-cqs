import type { TaskItem } from '@/entities/tasks/types/task-item.ts'
import { faker } from '@faker-js/faker'
import { TaskStateEnum } from '@/entities/tasks/types/state-enum.ts'

export class TaskBuilder {
  private task: TaskItem

  private constructor(task: TaskItem) {
    this.task = task
  }

  public static create(): TaskBuilder {
    return new TaskBuilder({
      id: faker.string.uuid(),
      name: faker.company.name(),
      state: TaskStateEnum.enum.Todo,
      expectedAt: {
        date: faker.date.soon().toDateString(),
        timezone: faker.date.timeZone(),
      },
    })
  }
}
