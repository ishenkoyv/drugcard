<?php

namespace App\Service\Infrastructure;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class ProductCrawler
{
    private array $urls = [
        'https://mida.mk.ua/grocery/groats',
        'https://mida.mk.ua/grocery/groats?page=2',
        'https://mida.mk.ua/grocery/groats?page=3',
    ];

    public function __construct(private HttpClientInterface $httpClient) {
    }

    public function crawl(): array
    {
        $productsArray = [];

        foreach ($this->urls as $url) {
            $response = $this->httpClient->request('GET', $url);
            $htmlContent = $response->getContent();

            $crawler = new Crawler($htmlContent);

            $crawler->filterXPath('//div[contains(@class, "subcategory_list")]//div[contains(concat(\' \', @class, \' \'), \' item \')]')->each(function (Crawler $node) use (&$productsArray) {
                $name = trim($node->filterXPath('.//div[contains(@class, "name")]')->text());
                $priceText = trim($node->filterXPath('.//div[contains(@class, "price")]')->text());
                preg_match('/([\d.,]+)/', $priceText, $matches);
                $price = isset($matches[1]) ? floatval(str_replace(',', '.', $matches[1])) : null;
                $productImageUrl = trim($node->filterXPath('.//img[contains(@class, "product_image")]/@src')->text());
                $productUrl = trim($node->filterXPath('.//a[2]/@href')->text());

                $productsArray[] = [
                    'name' => $name,
                    'price' => $price,
                    'imageUrl' => $productImageUrl,
                    'productUrl' => $productUrl,
                ];
            });
        }

        return $productsArray;
    }
}
