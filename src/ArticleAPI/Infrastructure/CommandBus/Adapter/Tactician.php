<?php

namespace App\ArticleAPI\Infrastructure\CommandBus\Adapter;

use App\ArticleAPI\Application\CommandBusInterface;
use League\Tactician\CommandBus;

class Tactician implements CommandBusInterface
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $command
     */
    public function handle($command)
    {
        $this->commandBus->handle($command);
    }
}
