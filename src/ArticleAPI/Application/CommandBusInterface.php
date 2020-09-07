<?php

namespace App\ArticleAPI\Application;

interface CommandBusInterface
{
    /**
     * @param $command
     */
    public function handle($command);
}
