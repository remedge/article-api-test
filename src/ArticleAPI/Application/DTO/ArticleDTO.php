<?php

namespace App\ArticleAPI\Application\DTO;

use App\ArticleAPI\Domain\Article;

class ArticleDTO
{
    public $data;

    public function __construct(Article $article)
    {
        $this->data = [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'body' => $article->getBody(),
            'createdAt' => $article->getCreatedAt(),
            'updatedAt' => $article->getUpdatedAt(),
        ];
    }
}
