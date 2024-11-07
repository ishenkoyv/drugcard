<?php

namespace App\Tests\Mapper;

use App\Dto\ProductDto;
use App\Mapper\ProductMapper;
use App\Mapper\ProductMappingException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class ProductMapperTest extends KernelTestCase
{
    private ProductMapper $productMapper;

    protected function setUp(): void
    {
        $validator = Validation::createValidator();
        $this->productMapper = new ProductMapper($validator);
    }

    public function testMapToDtoWithValidData()
    {
        $data = [
            'name' => 'Test Product',
            'price' => '19.99',
            'imageUrl' => 'http://example.com/image.jpg',
            'productUrl' => 'http://example.com/product'
        ];

        $productDto = $this->productMapper->mapToDto($data);

        $this->assertInstanceOf(ProductDto::class, $productDto);
        $this->assertEquals('Test Product', $productDto->getName());
        $this->assertEquals(19.99, $productDto->getPrice());
        $this->assertEquals('http://example.com/image.jpg', $productDto->getImageUrl());
        $this->assertEquals('http://example.com/product', $productDto->getProductUrl());
    }

    public function testMapToDtoWithInvalidData()
    {
        $data = [
            'name' => '',
            'price' => '19.99',
            'imageUrl' => 'http://example.com/image.jpg',
            'productUrl' => 'http://example.com/product'
        ];

        $this->expectException(ProductMappingException::class);

        $this->productMapper->mapToDto($data);
    }

    public function testMapToDtoWithNegativePrice()
    {
        $data = [
            'name' => 'Test Product',
            'price' => '-5.00',
            'imageUrl' => 'http://example.com/image.jpg',
            'productUrl' => 'http://example.com/product'
        ];

        $this->expectException(ProductMappingException::class);

        $this->productMapper->mapToDto($data);
    }

    public function testMapToDtoWithInvalidImageUrl()
    {
        $data = [
            'name' => 'Test Product',
            'price' => '19.99',
            'imageUrl' => '',
            'productUrl' => 'http://example.com/product'
        ];

        $this->expectException(ProductMappingException::class);

        $this->productMapper->mapToDto($data);
    }
}
