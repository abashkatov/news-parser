<?php

declare(strict_types=1);

namespace App\Model\Parser\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

final class WebClient implements ParserClientInterface
{
    /**
     * @param string $uri
     *
     * @throws GuzzleException
     *
     * @return Crawler
     */
    public function getCrawler(string $uri): Crawler
    {
        $client = new Client(
            [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Accept-Language' => 'ru-RU,ru;q=0.9,es-ES;q=0.8,es;q=0.7,en-US;q=0.6,en;q=0.5,zh-CN;q=0.4,zh;q=0.3',
                ],
            ]
        );

        $response = $client->get($uri);
        $content = $response->getBody()->getContents();

        return new Crawler($content);
    }
}
