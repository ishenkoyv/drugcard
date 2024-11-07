<?php

namespace App\Mapper;

use App\Dto\ProductDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProductMapper
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function mapToDto(array $data): ProductDto
    {
        $data['name'] = trim($data['name'] ?? '');
        $data['price'] = floatval(trim($data['price'] ?? 0));
        $data['imageUrl'] = trim($data['imageUrl'] ?? '');
        $data['productUrl'] = trim($data['productUrl'] ?? '');

        $this->validateRawValues($data);

        return new ProductDto($data['name'], $data['price'], $data['imageUrl'], $data['productUrl']);
    }

    private function validateRawValues(array $data): void
    {
        $constraints = new Assert\Collection([
            'name' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255]),
            ],
            'price' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'float']),
                new Assert\GreaterThan(['value' => 0]),
            ],
            'imageUrl' => [
                new Assert\NotBlank(),
                new Assert\Url(),
            ],
            'productUrl' => [
                new Assert\NotBlank(),
                new Assert\Url(),
            ],
        ]);

        $violations = $this->validator->validate($data, $constraints);

        if (count($violations) > 0) {
            throw new ProductMappingException((string) $violations . print_r($data, 1));
        }
    }
}

