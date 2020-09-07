<?php

namespace App\ArticleAPI\Application\DTO;

class ArticleListDTO
{
    public $data;

    public function __construct(array $articles)
    {
        foreach ($articles as $article) {
            $this->data[] = new ArticleDTO($article);
        }
    }
}
