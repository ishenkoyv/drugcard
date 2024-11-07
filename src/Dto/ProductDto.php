<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ProductDto
{
    /**
     * @Assert\NotBlank(message="Name should not be blank.")
     * @Assert\Length(max=255, maxMessage="Name cannot be longer than {{ limit }} characters.")
     */
    private string $name;

    /**
     * @Assert\NotBlank(message="Price should not be blank.")
     * @Assert\Type(type="numeric", message="Price must be a number.")
     * @Assert\GreaterThan(value=0, message="Price must be greater than zero.")
     */
    private float $price;

    /**
     * @Assert\NotBlank(message="Image URL should not be blank.")
     * @Assert\Url(message="Image URL is not valid.")
     */
    private string $imageUrl;

    /**
     * @Assert\NotBlank(message="Product URL should not be blank.")
     * @Assert\Url(message="Product URL is not valid.")
     */
    private string $productUrl;

    public function __construct(string $name, float $price, string $imageUrl, string $productUrl)
    {
        $this->name = $name;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->productUrl = $productUrl;
    }

    // Getters and Setters
    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getProductUrl(): string
    {
        return $this->productUrl;
    }

    public function getProductData(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'imageUrl' => $this->imageUrl,
            'productUrl' => $this->productUrl,
        ];
    }
}
