<?php

declare(strict_types=1);

namespace App\Model\Parser\ContentParser;

use App\Entity\News;
use App\Model\Parser\Dto\LinkDto;
use App\Model\Parser\Dto\SelectorDto;
use Symfony\Component\DomCrawler\Crawler;

final class SelectorParser
{
    public function parseLink(LinkDto $link, SelectorDto $selector): News
    {
        $news = new News();
        $content = \file_get_contents($link->getUrl());
        $crawler = new Crawler($content);

        $news->setTitle(
            $crawler->filter($selector->getTitle())->text()
        );

        $news->setOverview(
            $crawler->filter($selector->getOverview())->text()
        );

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
