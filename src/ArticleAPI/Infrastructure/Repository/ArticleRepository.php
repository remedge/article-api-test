<?php

namespace App\ArticleAPI\Infrastructure\Repository;

use App\ArticleAPI\Domain\Article;
use App\ArticleAPI\Domain\ArticleRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

const ITEMS_PER_PAGE = 10;

class ArticleRepository implements ArticleRepositoryInterface
{
    private $manager;

    /** @var EntityRepository */
    private $entityRepository;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->entityRepository = $this->manager->getRepository(Article::class);
    }

    public function save(Article $article)
    {
        $this->manager->persist($article);
        $this->manager->flush();
    }

    public function delete(Article $article)
    {
        $this->manager->remove($article);
        $this->manager->flush();
    }

    public function getByParameters(int $page, ?string $sortByField, ?string $sortOrder): array
    {
        $qb = $this->entityRepository
            ->createQueryBuilder('a');

        if ($sortByField && $sortOrder) {
            $qb->orderBy('a.'.$sortByField, $sortOrder);
        }

        $query = $qb->setFirstResult($page * ITEMS_PER_PAGE)
            ->setMaxResults(ITEMS_PER_PAGE)
            ->getQuery();

        return $query->getResult();
    }

    public function getById(int $id)
    {
        return $this->entityRepository->findOneById($id);
    }

    public function create(string $title, string $body)
    {
        $article = new Article();

        $article->setTitle($title);
        $article->setBody($body);
        $article->setCreatedAt(new \DateTime());
        $article->setUpdatedAt(new \DateTime());

        $this->manager->persist($article);
        $this->manager->flush();

        return $article;
    }
}
