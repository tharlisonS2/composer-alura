<?php

namespace Tharlisons2\BuscadorCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private $httpclient;
    private $crawler;
    public function __construct(ClientInterface $httpclient, Crawler $crawler)
    {
        $this->httpclient = $httpclient;
        $this->crawler = $crawler;
    }
    public function buscar(string $url): array
    {
        $response = $this->httpclient->request('GET', $url);
        $html = $response->getBody();

        $this->crawler = new Crawler();
        $this->crawler->addHtmlContent($html);

        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        $cursos = [];

        foreach ($elementosCursos as $elementos) {
            $cursos[] = $elementos->textContent;
        }

        return $cursos;
    }
}
