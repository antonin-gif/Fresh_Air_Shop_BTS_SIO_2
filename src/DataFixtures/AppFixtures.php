<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use Liior\Faker\Prices;
use App\Entity\Category;
use App\Entity\Purchase;
use App\Entity\PurchaseLine;
use Bezhanov\Faker\Provider\Commerce;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    protected $slugger;
    protected $encoder;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $encoder)
    {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        $admin = new User;

        $hash = $this->encoder->hashPassword($admin, "password");

        $admin->setEmail("admin@gmail.com")
            ->setPassword($hash)
            ->setFullName("Admin")
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $users = [];

        for ($u = 0; $u < 5; $u++) {
            $user = new User();

            $hash = $this->encoder->hashPassword($user, "password");

            $user->setEmail("user$u@gmail.com")
                ->setFullName($faker->name())
                ->setPassword($hash);

            $users[] = $user;

            $manager->persist($user);
        }

        $products = [];

        for ($c = 0; $c < 3; $c++) { //on créé 3 catégories
            $category = new Category;
            $category
                ->setName($faker->department)
                ->setSlug(strtolower($this->slugger->slug($category->getName())));

            $manager->persist($category);

            for ($p = 0; $p < mt_rand(15, 20); $p++) { //à chaque caté créée on créé des produits qu'on relie à cette catégorie
                $product = new Product;
                $product
                    ->setName($faker->productName)
                    ->setPrice($faker->price(4000, 20000))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($category)
                    ->setShortDescription($faker->paragraph())
                    ->setMainPicture($faker->imageUrl(400, 400, true));

                $products[] = $product; //on rajoute un product dans le tableau products, dans le but de 'remplir' une commande

                $manager->persist($product);
            }
        }

        for ($p = 0; $p < 40; $p++) {
            $purchase = new Purchase;
            $purchase
                ->setFullName($faker->name)
                ->setAddress($faker->streetAddress())
                ->setPostCode($faker->postcode())
                ->setCity($faker->city)
                ->setUser($faker->randomElement($users))
                ->setTotalCost(mt_rand(2000, 30000))
                ->setPurchaseDate($faker->dateTimeBetween('-6 months'));

            $selectedProducts = $faker->randomElements($products, mt_rand(2, 8));

            foreach ($selectedProducts as $product) {
                $purchaseLine = new PurchaseLine;
                $purchaseLine
                    ->setProduct($product)
                    ->setQuantity(mt_rand(1, 4))
                    ->setProductName($product->getName())
                    ->setProductPrice($product->getPrice())
                    ->setTotal($purchaseLine->getProductPrice() * $purchaseLine->getQuantity())
                    ->setPurchase($purchase);
                $manager->persist($purchaseLine);
            }

            if ($faker->boolean(90)) { //faker envoie true 90% du temps
                $purchase->setStatus(Purchase::STATUS_PAID); //par défaut le status est PENDING
            }

            $manager->persist($purchase);
        }

        $manager->flush();
    }
}
