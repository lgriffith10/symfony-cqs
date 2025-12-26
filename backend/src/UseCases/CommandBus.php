<?php

namespace App\UseCases;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus
{
    use HandleTrait;

    function __construct(
        private MessageBusInterface $messageBus,
    )
    {
    }

    public function execute($command): \Throwable
    {
        try {
            return $this->handle($command);
        } catch (HandlerFailedException $e) {
            $currentException = $e;
            while ($currentException instanceof HandlerFailedException) {
                $currentException = $currentException->getPrevious();
            }

            throw $currentException ?? $e;
        }
    }
}