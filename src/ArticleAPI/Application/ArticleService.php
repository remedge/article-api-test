<?php

namespace App\ArticleAPI\Application;

use App\ArticleAPI\Application\DTO\ArticleDTO;
use App\ArticleAPI\Application\DTO\ArticleListDTO;
use App\ArticleAPI\Domain\ArticleRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
    private $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getArticlesByParameters(int $page, ?string $sortByField, ?string $sortOrder)
    {
        $articles = $this->articleRepository->getByParameters($page, $sortByField, $sortOrder);

        return new ArticleListDTO($articles);
    }

    public function getArticleById(int $id)
    {
        $article = $this->articleRepository->getById($id);

        if ($article) {
            return new ArticleDTO($article);
        }

        return null;
    }

    public function createArticle(string $title, string $body)
    {
        $this->articleRepository->create($title, $body);
    }

    public function editArticle(int $id, string $title, string $body)
    {
        $article = $this->articleRepository->getById($id);

        if (!$article) {
            throw new \Exception('Article not found');
        }

        $article->setTitle($title);
        $article->setBody($body);
        $article->setUpdatedAt(new \DateTime());

        $this->articleRepository->save($article);
    }

    public function deleteArticle(int $id)
    {
        $article = $this->articleRepository->getById($id);

        if (!$article) {
            throw new \Exception('Article not found');
        }

        $this->articleRepository->delete($article);
    }
}
