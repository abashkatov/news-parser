<?php

declare(strict_types=1);

namespace App\Model\Parser\Client;

use Symfony\Component\DomCrawler\Crawler;

final class FileClient implements ParserClientInterface
{
    public function getCrawler(string $uri): Crawler
    {
        $content = \file_get_contents($uri);

        return new Crawler($content);
    }
}
