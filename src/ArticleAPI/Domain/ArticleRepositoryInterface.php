<?php

namespace App\ArticleAPI\Domain;

interface ArticleRepositoryInterface
{
    public function getByParameters(int $page, ?string $sortByField, ?string $sortOrder): array;

    public function getById(int $id);

    public function create(string $title, string $body);
}
