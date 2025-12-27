<?php

namespace Integrations\Task;

use App\Test\Factory\TaskFactory;
use App\Tests\Integrations\BaseIntegrationTest;

final class EditTaskTest extends BaseIntegrationTest
{
    protected function setUp(): void
    {
        parent::setUp();

        $task = TaskFactory::createOne(['createdBy']);
    }

    public function test_ShouldSucceed(): void {

    }
}
