<?php

namespace App\ArticleAPI\Http\DataExtractor;

interface DataExtractorInterface
{
    public function extract(string $format, $data): array;
}
