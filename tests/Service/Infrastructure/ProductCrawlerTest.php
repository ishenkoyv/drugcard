<?php

namespace App\Tests\Service\Infrastructure;

use App\Service\Infrastructure\ProductCrawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\DomCrawler\Crawler;
use PHPUnit\Framework\TestCase;

class ProductCrawlerTest extends TestCase
{
    private ProductCrawler $productCrawler;

    protected function setUp(): void
    {
        // Mocking HttpClient
        $mockHttpClient = new MockHttpClient(function ($method, $url) {
            // Mock response for the given URL
            return new MockResponse($this->getMockHtml());
        });

        // Create an instance of ProductCrawler with the mocked HttpClient
        $this->productCrawler = new ProductCrawler($mockHttpClient);
    }

    public function testCrawlReturnsProducts()
    {
        $products = $this->productCrawler->crawl();

        // Assert that we get an array of products
        $this->assertIsArray($products);
        $this->assertCount(6, $products); // Adjust based on your mock data

        // Assert the structure of the first product
        $this->assertArrayHasKey('name', $products[0]);
        $this->assertArrayHasKey('price', $products[0]);
        $this->assertArrayHasKey('imageUrl', $products[0]);
        $this->assertArrayHasKey('productUrl', $products[0]);

        // Assert values for the first product
        $this->assertEquals('Рис пропарений Art Foods к/у 4х100г', $products[0]['name']);
        $this->assertEquals(18.80, $products[0]['price']);
        $this->assertEquals('https://mida.mk.ua/image/cache/catalog/products/b40fef8a-fc8b-e16a-c228-c3b4e687f656-228x228.jpg', $products[0]['imageUrl']);
        $this->assertEquals('http://mida.mk.ua/grocery/groats/product-url-1', $products[0]['productUrl']);
    }

    private function getMockHtml(): string
    {
        return '
            <div class="subcategory_list">
                <div class="item">
                    <a class="liked " onclick="wishlist.add(88747, this);" ontouchend="wishlist.add(88747, this);"><i class="fa fa-heart"></i></a>
                    <a href="http://mida.mk.ua/grocery/groats/product-url-1">Product Link</a>
                    <div class="name">Рис пропарений Art Foods к/у 4х100г</div>
                    <div class="price">18.80 грн.</div>
                    <img class="product_image" src="https://mida.mk.ua/image/cache/catalog/products/b40fef8a-fc8b-e16a-c228-c3b4e687f656-228x228.jpg" alt="Рис пропарений Art Foods к/у 4х100г">
                </div>
                <div class="item">
                    <a class="liked " onclick="wishlist.add(88747, this);" ontouchend="wishlist.add(88748, this);"><i class="fa fa-heart"></i></a>
                    <a href="http://mida.mk.ua/grocery/groats/product-url-2">Product Link</a>
                    <div class="name">Гречка</div>
                    <div class="price">15.50 грн.</div>
                    <img class="product_image" src="https://mida.mk.ua/image/cache/catalog/products/b40fef8a-fc8b-e16a-c228-c3b4e687f656-228x228.jpg" alt="Гречка">
                </div>
            </div>
        ';
    }
}
