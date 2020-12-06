<?php

declare(strict_types=1);

namespace App\Tests\Model\Parser\ContentParser;

use App\Model\Parser\Client\FileClient;
use App\Model\Parser\ContentParser\SelectorParser;
use App\Model\Parser\Dto\LinkDto;
use App\Model\Parser\Dto\SelectorDto;
use PHPUnit\Framework\TestCase;

final class SelectorParserTest extends TestCase
{
    public function testParseLink(): void
    {
        $client = new FileClient();
        $parser = new SelectorParser($client);
        $link = new LinkDto(
            '',
            __DIR__ . '/../../../data/sites/news.rbc.ru.html'
        );
        $selector = new SelectorDto(
            '',
            'h1',
            '.article__text__overview>span',
            '.article__text.article__text_free>p',
            '.article__main-image__wrap>img'
        );

        $news = $parser->parseLink($link, $selector);
        self::assertSame('«Динамо» обыграло «Арсенал» и вышло на четвертое место в таблице', $news->getTitle());
        self::assertSame('Единственный мяч в матче забил Даниил Фомин на 45-й минуте', $news->getOverview());
        self::assertSame(
            '<p>В рамках 17-го тура чемпионата России «Динамо» встречалось с тульским «Арсеналом». Поединок прошел на стадионе «ВТБ Арена» в Москве и завершился со счетом 1:0 в пользу хозяев.</p><p>Единственный гол на 45-й минуте встречи забил полузащитник «бело-голубых» Даниил Фомин. На 88-й минуте на поле вышел нападающий «Арсенала» Евгений Луценко, который из-за травмы не принимал участия в играх с 20 сентября.</p><p>«Динамо» набрало 30 очков и поднялось в турнирной таблице на четвертое место, сместив оттуда «Ростов», у которого на один балл меньше. «Арсенал» с 14 баллами располагается на 13-й позиции. Лидирует «Зенит» с 35 очками.</p><p>В следующем туре москвичи в гостях встретятся с лидером чемпионата петербургским «Зенитом», поединок пройдет 12 декабря. «Арсенал» 11 декабря на выезде сыграет против подмосковных «Химок».</p>',
            $news->getContent()
        );
        self::assertSame('https://s0.rbk.ru/v6_top_pics/resized/1180xH/media/img/2/46/756072693089462.jpg', $news->getImageUrl());
    }
}
