<?php

namespace App\ArticleAPI\Domain\Bus;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
