<?php

namespace App\ArticleAPI\Http\DataExtractor;

use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class DataExtractor implements DataExtractorInterface
{
    public const JSON_COMMUNICATION_FORMAT = 'application/json';
    public const XML_COMMUNICATION_FORMAT = 'application/xml';

    public function extract(string $format, $data): array
    {
        $result = null;

        switch ($format) {
            case self::JSON_COMMUNICATION_FORMAT:
                $result = json_decode($data, true);
                break;
//            case self::XML_COMMUNICATION_FORMAT: - not implemented
//                break;
            default:
                throw new NotAcceptableHttpException('Content-type is not supported');
        }

        return $result;
    }
}
