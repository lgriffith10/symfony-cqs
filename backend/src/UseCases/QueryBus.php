<?php

namespace App\UseCases;

use App\Dtos\ApiResponse;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus
{
    use HandleTrait;

    function __construct(
        private MessageBusInterface $messageBus,
    )
    {
    }

    /**
     * @template T
     * @param object $query
     * @return ApiResponse<T>
     */
    public function query($query): mixed {
        $envelope = $this->messageBus->dispatch($query);
        return $envelope->last(HandledStamp::class)->getResult();
    }
}