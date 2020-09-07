<?php

namespace App\ArticleAPI\Http\Controller;

use App\ArticleAPI\Application\ArticleServiceInterface;
use App\ArticleAPI\Http\DataFormatter\DataFormatterInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetOneController
{
    /** @var ArticleServiceInterface */
    private $articleService;

    /** @var DataFormatterInterface */
    private $dataFormatter;

    public function __construct(ArticleServiceInterface $articleService, DataFormatterInterface $dataFormatter)
    {
        $this->articleService = $articleService;
        $this->dataFormatter = $dataFormatter;
    }

    /**
     * @return Response
     * @SWG\Response(
     *     response=200,
     *     description="Returns single article item"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returns not found error"
     * )
     * @SWG\Response(
     *     response=500,
     *     description="Returns error"
     * )
     * @SWG\Tag(name="articles")
     */
    public function action(Request $request, int $id)
    {
        $acceptHeader = $request->headers->get('Accept') ?? $this->dataFormatter::JSON_COMMUNICATION_FORMAT;

        try {
            $article = $this->articleService->getArticleById($id);

            if (!$article) {
                return $this->dataFormatter->format($acceptHeader, ['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
            }

            return $this->dataFormatter->format($acceptHeader, $article);
        } catch (\Exception $e) {
            return $this->dataFormatter->format($acceptHeader, ['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
