<?php

declare(strict_types=1);

namespace App\Model\Parser;

use App\Model\Parser\Client\ParserClientInterface;
use App\Model\Parser\Dto\LinkDto;
use App\Model\Parser\Dto\SelectorDto;

final class LinkParser
{
    private ParserClientInterface $client;

    public function __construct(ParserClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string      $url
     * @param SelectorDto $selector
     *
     * @return LinkDto[]
     */
    public function parseLinks(string $url, SelectorDto $selector): array
    {
        $links = [];
        $crawler = $this->client->getCrawler($url);

        foreach ($crawler->filter($selector->getLink())->getIterator() as $node) {
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
