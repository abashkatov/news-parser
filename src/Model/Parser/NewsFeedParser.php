<?php

declare(strict_types=1);

namespace App\Model\Parser;

use App\Entity\News;
use App\Model\Parser\ContentParser\SelectorParser;
use App\Model\Parser\Dto\SelectorDto;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class NewsFeedParser
{
    private LinkParser $linkParser;

    private SelectorParser $selectorParser;

    private LoggerInterface $logger;

    private ValidatorInterface $validator;

    public function __construct(
        LinkParser $linkParser,
        SelectorParser $selectorParser,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->linkParser = $linkParser;
        $this->selectorParser = $selectorParser;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    /**
     * Для расширения достаточно связки ссылка $uri и селекторы $selector сохранять в БД.
     *
     * @param string      $uri
     * @param SelectorDto $selector
     *
     * @return News[]
     */
    public function parseFeed(string $uri, SelectorDto $selector): array
    {
        $newsArray = [];
        $links = $this->linkParser->parseLinks($uri, $selector);
        foreach ($links as $link) {
            try {
                $news = $this->selectorParser->parseLink($link, $selector);
            } catch (\Throwable $e) {
                $this->logger->error('Не удалось спарсить новость', ['url' => $link->getUrl()]);

                continue;
            }
            $errors = $this->validator->validate($news);
            if ($errors->count() > 0) {
                $this->logger->info(
                    'Новость уже добавлена в базу',
                    [
                        'title' => $link->getTitle(),
                        'url' => $link->getUrl(),
                    ]
                );

                continue;
            }
            $newsArray[] = $news;
        }

        return $newsArray;
    }
}
