<?php

namespace App\Model\Parser\Client;

use Symfony\Component\DomCrawler\Crawler;

interface ParserClientInterface
{
    public function getCrawler(string $uri): Crawler;
}
