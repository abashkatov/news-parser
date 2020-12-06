<?php

declare(strict_types=1);

namespace App\Model\Parser;

use App\Model\Parser\Dto\LinkDto;
use Symfony\Component\DomCrawler\Crawler;

final class LinkParser
{
    /**
     * @param string $url
     * @param string $selector
     *
     * @return LinkDto[]
     */
    public function parseLinks(string $url, string $selector): array
    {
        $links = [];
        $content = \file_get_contents($url);
        $crawler = new Crawler($content);
        foreach ($crawler->filter($selector)->getIterator() as $node) {
            $links[] = $this->mapToLinkDto($node);
        }

        return $links;
    }

    private function mapToLinkDto(\DOMNode $node): LinkDto
    {
        $title = \preg_replace('/(\s+)/', ' ', $node->textContent);

        return new LinkDto(
            $title,
            $node->attributes->getNamedItem('href')->textContent
        );
    }
}
