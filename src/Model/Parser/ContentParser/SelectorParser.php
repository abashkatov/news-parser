<?php

declare(strict_types=1);

namespace App\Model\Parser\ContentParser;

use App\Entity\News;
use App\Model\Parser\Client\ParserClientInterface;
use App\Model\Parser\Dto\LinkDto;
use App\Model\Parser\Dto\SelectorDto;

final class SelectorParser
{
    private ParserClientInterface $client;

    public function __construct(ParserClientInterface $client)
    {
        $this->client = $client;
    }

    public function parseLink(LinkDto $link, SelectorDto $selector): News
    {
        $news = new News();
        $crawler = $this->client->getCrawler($link->getUrl());

        $news->setTitle(
            $crawler->filter($selector->getTitle())->text()
        );

        $overviewElement = $crawler->filter($selector->getOverview());
        if ($overviewElement->count() > 0) {
            $news->setOverview($overviewElement->text());
        }

        $content = '';
        foreach ($crawler->filter($selector->getContent()) as $node) {
            $nodeContent = \trim($node->textContent);
            if (\mb_strlen($nodeContent) > 1) {
                $content .= '<p>' . $nodeContent . '</p>';
            }
        }
        $news->setContent($content);

        $image = $crawler->filter($selector->getImage());
        if (1 === $image->count()) {
            $news->setImageUrl($image->attr('src'));
        }

        return $news;
    }
}
