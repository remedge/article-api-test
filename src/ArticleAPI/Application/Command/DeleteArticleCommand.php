<?php

namespace App\ArticleAPI\Application\Command;

use App\ArticleAPI\Domain\Bus\Command as BaseCommand;

class DeleteArticleCommand implements BaseCommand
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
