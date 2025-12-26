<?php

namespace App\UseCases;

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

    public function query($query): mixed {
        return $this->handle($query);
    }
}