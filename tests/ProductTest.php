<?php

namespace App\tests;

use App\Entity\Product;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Validator\Validation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ProductTest extends KernelTestCase
{
    private const NAME_CONSTRAINT_MINMESSAGE = 'Le nom du produit doit faire au moins 3 caractères';
    private const NAME_NOT_BLANK_MESSAGE = 'Le nom du produit est obligatoire';
    private const INVALID_NAME_VALUE = "a";

    private const PRICE_NOT_BLANK_MESSAGE = 'Le prix du produit est obligatoire';
    private const VALID_NAME_VALUE = "Tente 5 places";
    private const VALID_PRICE_VALUE = 5;

    private const MAINPICTURE_NOT_BLANK_MESSAGE = "La photo principale est obligatoire";
    private const INVALID_MAINPICTURE_VALUE = "";
    private const VALID_MAINPICTURE_VALUE = "pictures/tente.jpg";

    private const SHORTDESCRIPTION_NOT_BLANK_MESSAGE = "";
    private const SHORTDESCRIPTION_LENGTH_MESSAGE = "La description courte doit quand meme faire au moins 20 caractères";
    private const VALID_SHORTDESCRIPTION_VALUE = "Une description suffisamment longue";

    private ValidatorInterface $validfffator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->validator = $kernel->getContainer()->get('validator');
    }

    /**
     * @test
     */
    public function ProductEntityIsValid(): void
    {
        $product = new Product();

        $product
            ->setName(self::VALID_NAME_VALUE)
            ->setPrice(self::VALID_PRICE_VALUE)
            ->setMainPicture(self::VALID_MAINPICTURE_VALUE)
            ->setShortDescription(self::VALID_SHORTDESCRIPTION_VALUE);

        $this->getValidatorErrors($product, 0);
    }

    private function getValidatorErrors(Product $product, int $numberOfExpectedErrors): ConstraintViolationList
    {

        $errors = $this->validator->validate($product);

        $this->assertCount($numberOfExpectedErrors, $errors);

        return $errors;
    }
}
