<?php

namespace App\ArticleAPI\Http\DataFormatter;

use Symfony\Component\HttpFoundation\Response;

interface DataFormatterInterface
{
    public function format(string $format, $data, $httpCode = null): Response;
}
