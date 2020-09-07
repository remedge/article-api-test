<?php

namespace App\ArticleAPI\Application\Handler;

use App\ArticleAPI\Application\ArticleServiceInterface;
use App\ArticleAPI\Application\Command\CreateArticleCommand;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CreateArticleHandler
{
    private $articleService;

    private $params;

    public function __construct(ArticleServiceInterface $articleService, ParameterBagInterface $params)
    {
        $this->articleService = $articleService;
        $this->params = $params;
    }

    public function handle(CreateArticleCommand $command)
    {
        $this->articleService->createArticle($command->title, $command->body);
    }
}
