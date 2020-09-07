<?php

namespace App\ArticleAPI\Http\Controller;

use App\ArticleAPI\Application\ArticleServiceInterface;
use App\ArticleAPI\Application\Command\EditArticleCommand;
use App\ArticleAPI\Application\CommandBusInterface;
use App\ArticleAPI\Http\DataExtractor\DataExtractorInterface;
use App\ArticleAPI\Http\DataFormatter\DataFormatterInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;

class EditController implements TokenAuthenticatedController
{
    /** @var ArticleServiceInterface */
    private $articleService;

    /** @var CommandBusInterface */
    private $commandBus;

    /** @var DataFormatterInterface */
    private $dataFormatter;

    /** @var DataExtractorInterface */
    private $dataExtractor;

    public function __construct(
        ArticleServiceInterface $articleService,
        CommandBusInterface $commandBus,
        DataFormatterInterface $dataFormatter,
        DataExtractorInterface $dataExtractor
    ) {
        $this->articleService = $articleService;
        $this->commandBus = $commandBus;
        $this->dataFormatter = $dataFormatter;
        $this->dataExtractor = $dataExtractor;
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
     * @SWG\Response(
     *     response=400,
     *     description="Returns validation error"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Payload",
     *     required=true,
     *     format="application/json",
     *     @SWG\Schema(
     *          type="object",
     *          @SWG\Property(property="title", type="string", example="Some title"),
     *          @SWG\Property(property="body", type="string", example="Some body"),
     *     )
     * ),
     * @SWG\Tag(name="articles")
     */
    public function action(Request $request, int $id)
    {
        $acceptHeader = $request->headers->get('Accept') ?? $this->dataFormatter::JSON_COMMUNICATION_FORMAT;
        $contentTypeHeader = $request->headers->get('content-type') ?? $this->dataExtractor::JSON_COMMUNICATION_FORMAT;
        $payload = $this->dataExtractor->extract($contentTypeHeader, $request->getContent());

        $validator = Validation::createValidator();
        $resultViolations = [];

        $validateValues = [
            [
                'title' => 'title',
                'value' => $payload['title'] ?? null,
                'constraint' => [new NotBlank(), new Length(['max' => 100])],
            ],
            [
                'title' => 'body',
                'value' => $payload['body'] ?? null,
                'constraint' => new NotBlank(),
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
            $command = new EditArticleCommand($id, $payload['title'], $payload['body']);
            $this->commandBus->handle($command);

            return $this->dataFormatter->format($acceptHeader, ['message' => 'Article successfully updated']);
        } catch (\Exception $exception) {
            return $this->dataFormatter->format($acceptHeader, ['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
