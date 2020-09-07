<?php

namespace App\ArticleAPI\Application\Command;

use App\ArticleAPI\Domain\Bus\Command as BaseCommand;

class CreateArticleCommand implements BaseCommand
{
    public $title;
    public $body;

    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
    }
}
