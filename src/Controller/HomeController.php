<?php

namespace App\Controller;

use Faker\Factory;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(ProductRepository $productRepository)
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        $product = $productRepository->findAll();
        $selectedProducts = $faker->randomElements($product, 4);

        return $this->render('home.html.twig', [
            'products' => $selectedProducts
        ]);
    }
}
