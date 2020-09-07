<?php

namespace App\ArticleAPI\Application\Handler;

use App\ArticleAPI\Application\ArticleServiceInterface;
use App\ArticleAPI\Application\Command\EditArticleCommand;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EditArticleHandler
{
    private $articleService;

    private $params;

    public function __construct(ArticleServiceInterface $articleService, ParameterBagInterface $params)
    {
        $this->articleService = $articleService;
        $this->params = $params;
    }

    public function handle(EditArticleCommand $command)
    {
        $this->articleService->editArticle($command->id, $command->title, $command->body);
    }
}
