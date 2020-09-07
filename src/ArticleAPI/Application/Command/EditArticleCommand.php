<?php

namespace App\ArticleAPI\Application\Command;

use App\ArticleAPI\Domain\Bus\Command as BaseCommand;

class EditArticleCommand implements BaseCommand
{
    public $id;
    public $title;
    public $body;

    public function __construct(int $id, string $title, string $body)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
    }
}
