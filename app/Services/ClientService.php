<?php


namespace App\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class ClientService
{

    const MIN_DELAY = 2000;
    const MAX_DELAY = 5000;


    protected  $client;

    /**
     * @var array
     */
    protected array $options = [];


    public function __construct()
    {

    }

    /**
     * @param array $options
     * @return ClientService
     */
    public function setOptions(array $options): ClientService
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param array $options
     * @return ClientService
     */
    public function addOptions(array $options): ClientService
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * @param string $url
     * @param array $options
     * @param string $method
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function newRequest(string $url, array $options = [], string $method = 'GET'): ResponseInterface
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        $options = array_merge($this->getDefaultOptions(), $this->options, $options);

        return $this->client->request($method, $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @param string $method
     * @return string
     * @throws GuzzleException
     */
    protected function getHtml(string $url, array $options = [], string $method = 'GET'): string
    {
        return $this->newRequest($url, $options, $method)->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array $options
     * @param string $method
     * @return Crawler
     * @throws GuzzleException
     */
    public function getCrawler(string $url, array $options = [], string $method = 'GET'): Crawler
    {
        $html = $this->getHtml($url, $options, $method);
        $crawler = new Crawler();
//        $crawler->addHtmlContent($html, 'UTF-8');
        $crawler->addContent($html, 'text/html; charset=utf-8');
        return $crawler;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getDefaultOptions(): array
    {
        return ['delay' => random_int(static::MIN_DELAY, static::MAX_DELAY) ];
    }
}
