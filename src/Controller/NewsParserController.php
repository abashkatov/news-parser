<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\News;
use App\Model\Parser\Dto\SelectorDto;
use App\Model\Parser\NewsFeedParser;
use App\Repository\NewsRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class NewsParserController extends AbstractController
{
    private NewsFeedParser $feedParser;

    private NewsRepository $newsRepository;

    public function __construct(
        NewsFeedParser $feedParser,
        NewsRepository $newsRepository
    ) {
        $this->feedParser = $feedParser;
        $this->newsRepository = $newsRepository;
    }

    /**
     * @Route(path="/", name="app_newsparser_mainpage")
     *
     * @param Request $request
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @return Response
     */
    public function mainPage(Request $request): Response
    {
        $runParser = '1' === $request->get('runparser');
        if ($runParser) {
            // Сдесь используются статические ссылка и набор селекторов. Их можно хранить в БД.
            // Возможность расширения функционала парсинга для добавления дополнительных новостных ресурсов присутствует.
            $uri = 'https://www.rbc.ru/';
            $selector = new SelectorDto(
                'a.news-feed__item.js-news-feed-item',
                'h1',
                '.article__text__overview>span',
                '.article__text.article__text_free>p',
                '.article__main-image__wrap>img'
            );
            $newsArray = $this->feedParser->parseFeed($uri, $selector);
            $this->newsRepository->persistAndFlush($newsArray);
        }
        $newsArray = $this->newsRepository->findAll();

        return $this->render('main-page.html.twig', ['newsArray' => $newsArray]);
    }

    /**
     * @Route(path="/news/{news}", name="app_newsparser_newspage")
     *
     * @param News $news
     *
     * @return Response
     */
    public function newsPage(News $news): Response
    {
        return $this->render('news-page.html.twig', ['news' => $news]);
    }
}
