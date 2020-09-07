<?php

namespace App\ArticleAPI\Http\DataFormatter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class DataFormatter implements DataFormatterInterface
{
    public const JSON_COMMUNICATION_FORMAT = 'application/json';
    public const XML_COMMUNICATION_FORMAT = 'application/xml';

    public function format(string $format, $data, $httpCode = Response::HTTP_OK): Response
    {
        $result = null;

        switch ($format) {
            case '*/*':
            case self::JSON_COMMUNICATION_FORMAT:
                $result = new JsonResponse($data, $httpCode);
                break;
//            case self::XML_COMMUNICATION_FORMAT: - not implemented
//                break;
            default:
                throw new NotAcceptableHttpException('Accept type not supported');
        }

        return $result;
    }
}
