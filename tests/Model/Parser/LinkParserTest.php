<?php

declare(strict_types=1);

namespace App\Tests\Model\Parser;

use App\Model\Parser\Client\FileClient;
use App\Model\Parser\Dto\SelectorDto;
use App\Model\Parser\LinkParser;
use PHPUnit\Framework\TestCase;

final class LinkParserTest extends TestCase
{
    public function testParseLinks(): void
    {
        $client = new FileClient();
        $parser = new LinkParser($client);
        $selector = new SelectorDto(
            'a.news-feed__item.js-news-feed-item',
            '',
            '',
            '',
            ''
        );
        $links = $parser->parseLinks(__DIR__ . '/../../data/sites/rbc.ru.html', $selector);
        self::assertCount(14, $links);
        $firstLink = \array_shift($links);
        self::assertSame('Суд оштрафовал жителя Самары за кепку с изображением конопли Общество, 20:29', \trim($firstLink->getTitle()));
        self::assertSame('https://www.rbc.ru/rbcfreenews/5fcd0ce79a79479eea88e2cd?from=newsfeed', $firstLink->getUrl());
    }
}
