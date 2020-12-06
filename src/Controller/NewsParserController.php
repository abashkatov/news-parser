<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class NewsParserController extends AbstractController
{
    /**
     * @Route(path="/", name="app_newsparser_page")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function page(Request $request): Response
    {
        $runParser = '1' === $request->get('runparser');

        return $this->render('page.html.twig');
    }
}
