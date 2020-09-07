<?php

namespace App\ArticleAPI\Application\Handler;

use App\ArticleAPI\Application\ArticleServiceInterface;
use App\ArticleAPI\Application\Command\DeleteArticleCommand;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DeleteArticleHandler
{
    private $articleService;

    private $params;

    public function __construct(ArticleServiceInterface $articleService, ParameterBagInterface $params)
    {
        $this->articleService = $articleService;
        $this->params = $params;
    }

    public function handle(DeleteArticleCommand $command)
    {
        $this->articleService->deleteArticle($command->id);
    }
}
