<?php

namespace App\UseCases;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus
{
    use HandleTrait;

    function __construct(
        private MessageBusInterface $messageBus,
    )
    {
    }

    public function query($query): \Throwable {
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $e) {
            $currentException = $e;
            while ($currentException instanceof HandlerFailedException) {
                $currentException = $currentException->getPrevious();
            }

            throw $currentException ?? $e;
        }
    }
}