<?php

namespace App\ArticleAPI\Application;

interface ArticleServiceInterface
{
    public function getArticlesByParameters(int $page, string $sortByField, string $sortOrder);

    public function getArticleById(int $id);

    public function createArticle(string $title, string $body);

    public function editArticle(int $id, string $title, string $body);

    public function deleteArticle(int $id);
}
