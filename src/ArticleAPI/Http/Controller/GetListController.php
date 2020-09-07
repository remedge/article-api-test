<?php

namespace App\ArticleAPI\Http\Controller;

use App\ArticleAPI\Application\ArticleServiceInterface;
use App\ArticleAPI\Http\DataFormatter\DataFormatterInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;

class GetListController
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
     * @param Request $request
     * @return Response
     * @SWG\Response(
     *     response=200,
     *     description="Returns the articles list"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returns validation error"
     * )
     * @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     type="integer",
     *     description="current page",
     *     default="1"
     * )
     * @SWG\Parameter(
     *     name="sortByField",
     *     in="query",
     *     type="string",
     *     description="order field",
     *     default="id"
     * )
     * @SWG\Parameter(
     *     name="sortOrder",
     *     in="query",
     *     type="string",
     *     description="order direction",
     *     default="desc"
     * )
     * @SWG\Tag(name="articles")
     */
    public function action(Request $request)
    {
        $acceptHeader = $request->headers->get('Accept') ?? $this->dataFormatter::JSON_COMMUNICATION_FORMAT;

        $page = $request->query->getInt('page', 1);
        $sortByField = $request->query->get('sortByField', 'id');
        $sortOrder = $request->query->get('sortOrder', 'desc');

        $validator = Validation::createValidator();
        $resultViolations = [];

        $validateValues = [
            [
                'title' => 'page',
                'value' => $page,
                'constraint' => new Positive(),
            ],
            [
                'title' => 'sortByField',
                'value' => $sortByField,
                'constraint' => new Choice(['id', 'title', 'body', 'createdAt', 'updatedAt']),
            ],
            [
                'title' => 'sortOrder',
                'value' => $sortOrder,
                'constraint' => new Choice(['asc', 'desc']),
            ],
        ];

        foreach ($validateValues as $validateValue) {
            $violations = $validator->validate($validateValue['value'], $validateValue['constraint']);
            if (0 !== count($violations)) {
                /** @var ConstraintViolationInterface $violation */
                foreach ($violations as $violation) {
                    $resultViolations[$validateValue['title']][] = $violation->getMessage();
                }
            }
        }

        if (count($resultViolations) > 0) {
            return $this->dataFormatter->format($acceptHeader, $resultViolations, Response::HTTP_BAD_REQUEST);
        }

        try {
            $articles = $this->articleService->getArticlesByParameters($page, $sortByField, $sortOrder);

            return $this->dataFormatter->format($acceptHeader, $articles);
        } catch (\Exception $e) {
            return $this->dataFormatter->format($acceptHeader, ['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
