<?php

namespace App\ArticleAPI\Http\Controller;

use App\ArticleAPI\Application\ArticleServiceInterface;
use App\ArticleAPI\Application\Command\DeleteArticleCommand;
use App\ArticleAPI\Application\CommandBusInterface;
use App\ArticleAPI\Http\DataFormatter\DataFormatterInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteController implements TokenAuthenticatedController
{
    /** @var ArticleServiceInterface */
    private $articleService;

    /** @var CommandBusInterface */
    private $commandBus;

    /** @var DataFormatterInterface */
    private $dataFormatter;

    public function __construct(
        ArticleServiceInterface $articleService,
        CommandBusInterface $commandBus,
        DataFormatterInterface $dataFormatter
    ) {
        $this->articleService = $articleService;
        $this->commandBus = $commandBus;
        $this->dataFormatter = $dataFormatter;
    }

    /**
     * @return Response
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer 123",
     *     description="Authorization"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns success message"
     * )
     * @SWG\Response(
     *     response=500,
     *     description="Returns error"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returns security error"
     * )
     * @SWG\Tag(name="articles")
     */
    public function action(Request $request, int $id)
    {
        $acceptHeader = $request->headers->get('Accept') ?? $this->dataFormatter::JSON_COMMUNICATION_FORMAT;

        try {
            $command = new DeleteArticleCommand($id);
            $this->commandBus->handle($command);

            return $this->dataFormatter->format($acceptHeader, ['message' => 'Article successfully deleted']);
        } catch (\Exception $exception) {
            return $this->dataFormatter->format($acceptHeader, ['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
