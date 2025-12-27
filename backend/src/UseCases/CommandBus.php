<?php

namespace App\UseCases;

use App\Dtos\ApiResponse;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CommandBus
{
    use HandleTrait;

    function __construct(
        private MessageBusInterface $messageBus,
    )
    {
    }

    /**
     * @template T
     * @param object $command
     * @return ApiResponse<T>
     */
    public function execute($command): mixed
    {
        $envelope = $this->messageBus->dispatch($command);
        return $envelope->last(HandledStamp::class)->getResult();
    }
}