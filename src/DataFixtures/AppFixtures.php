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

        $myCategories = ["Canoé", "Bivouac", "Pêche", "Randonnée"];
        $canoes = [
            "CANOE KAYAK GONFLABLE 2 PLACES",
            "CANOE KAYAK GONFLABLE 3 PLACES",
            "CANOE KAYAK DE RANDONNEE RIGIDE",
            "PACKRAFT 100 KAYAK GONFLABLE"
        ];
        $bivouac = [
            "TENTE DE TOIT",
            "MATELAS AUTOGONFLANT DE CAMPING",
            "LIT DE CAMP POUR LE CAMPING"
        ];
        $fishing = [
            "CUISSARDES DE PÊCHE",
            "LUNETTES DE PÊCHE POLARISANTES",
            "ENSEMBLE PECHE TELEREGLABLES",
            "MOULINET FREIN AVANT"
        ];
        $hiking = [
            "LUNETTES DE SOLEIL RANDONNÉE",
            "CHAUSSETTES DE RUNNING",
            "MONTRE CARDIO",
            "SAC À DOS DE RANDONNÉE"
        ];

        $pictureCanoe = ["pictures\canoe-kayak-gonflable-randonnee-fond-haute-pression-drop-stitch-x100-2-places.avif", "pictures\canoe-kayak-gonflable-randonnee-fond-haute-pression-drop-stitch-x100-3-places.avif", "pictures\canoe-kayak-de-randonnee-rigide-tahe-tobago-3-places-2-adultes-1-enfant.avif", "pictures\packraft-100-kayak-gonflable-tpu-riviere-1-place.avif"];
        $picturesBivouac = ["pictures\de-toit-van-500-fresh-and-black-2p.avif", "pictures\matelas-autogonflant-de-camping-ultim-comfort-70-cm-1-personne.avif", "pictures\lit-de-camp-pour-le-camping-camp-bed-basic-60-cm-1-personne.avif"];
        $picturesFishing = ["pictures\cuissardes-de-peche-100.avif", "pictures\lunettes-de-peche-polarisantes-skyrazer-500-grises.avif", "pictures\semble-peche-telereglables-set-fortec-legend-rc-380.avif", "pictures\moulinet-frein-avant-daiwa-ninja-lt-1000.avif"];
        $picturesHiking = ["pictures\lunettes-de-soleil-randonnee-mh140-adulte-polarisantes-categorie-3.avif", "pictures\chaussettes-de-running-run100-noire-x3.avif", "pictures\montre-cardio-gps-garmin-forerunner-245-grise.avif", "pictures\sac-a-dos-de-randonnee-30l-nh-arpenaz-500.avif"];

        $descriptionsCanoes = array("Notre équipe de passionnés a développé ce kayak pour les pratiquants débutants de randonnée, pour naviguer à 1 ou 2 personnes, en eaux calmes, de 2 à 3 heures. Un canoë kayak gonflable solide, avec fond Dropstich haute pression, offrant 2 places adultes surélevées pour un bon confort de rame. Le bon compromis entre la stabilité et la performance.", "Notre équipe de passionnés a développé ce kayak pour les pratiquants débutants de randonnée, pour naviguer à 2 ou 3 personnes, en eaux calmes, de 2 à 3 heures. Un canoë kayak gonflable solide, avec fond Dropstitch haute pression, offrant 3 places surélevées pour un bon confort de rame. Le bon compromis entre la stabilité et la performance.", "Notre équipe de passionnés a sélectionné ce kayak pour les pratiquants débutants de randonnée en lac, en rivière calme ou en mer (maxi 300 m d’un abri-France). Le kayak Tobago est parfaitement adapté à la balade familiale. Son siège central permet d’accueillir un enfant en plus des deux adultes prévus.", "Conçu pour le débutant en packrafting, ce packraft tient dans un sac à dos! Randonnez le long d'un cours d'eau calme ou d'un lac puis descendez ou traversez le ! La compacité ultime du packraft permet de vivre vos randonnées d'une autre manière, le long d'une rivière calme de classe 1 à descendre ou d'un lac à traverser: Créez votre aventure sur mesure.");

        $descriptionsBivouac = array("Envie de liberté? Nos concepteurs ont développé cette tente de toit gonflable pour van simple et rapide à installer, pour bouger au gré de vos envies. Offrez-vous plus du confort avec un véritable sommier et matelas gonflable. Profitez de la fraîcheur même en plein été grâce au tissu Fresh&Black et d'un espace ombragé avec le tarp Fresh.", "Nos concepteurs campeurs ont conçu ce matelas autogonflant Ultim Comfort très épais pour un campeur cherchant le confort comme à la maison. Notre motivation ? Vous proposer un matelas de 70 cm autogonflant très épais, jumelable et très simple d'installation pour un confort comme à la maison en camping.", "Nos concepteurs campeurs ont conçu ce lit de camping Camp Bed Basic pour les campeurs désirant s'isoler du sol tout en cherchant un maximum de compacité. Notre motivation ? Vous proposer un lit de camp bas et compact pour le camping. Le montage et le démontage sont faciles pour améliorer votre installation sur votre lieu de camping.");

        $descriptionsFishing = array("Nos concepteurs pêcheurs ont développé ces cuissardes pour vous permettre de pêcher en wading en restant au sec jusqu'aux genoux. Par leur composant, ces cuissardes vous offrent une grande résistance.", "Nos concepteurs pêcheurs ont développé ces lunettes polarisantes pour diminuer l'éblouissement lors de vos parties de pêches par temps ensoleillé. Elles diminuent les reflets du soleil sur l'eau et augmentent les contrastes pour mieux lire le spot de pêche grâce à leurs verres marrons. En plus, elles sont flottantes !", "Conçu pour le pêcheur de la truite au toc confirmé. Un modèle polyvalent qui ne manquera pas de ravir ceux qui pratiquent la pêche de la truite au toc.", "Ce moulinet de spinning léger, fluide et doté d'un très bon rapport qualité/prix. Le moulinet Daiwa Ninja LT conviendra aux pêcheurs débutants qui souhaitent progresser dans la pêche des carnassiers.");

        $descriptionsHiking = array("Nos ingénieurs optiques ont développé ces lunettes de soleil pour la randonnée. Idéales pour un usage occasionnel en montagne grâce à leur légèreté. Les verres anti-UV bloquent 100% des rayons nocifs et la catégorie 3 vous protège de l’éblouissement. La technologie des verres polarisants vous permet de mieux distinguer les reliefs et contrastes.", "Nos équipes de conception ont développé ces chaussettes de running pour que votre pied soit protégé des risques d'ampoules lors de vos sorties de course à pied. Des chaussettes de running à petit prix ? Grâce à leur fil en coton, leur tricotage fin et aéré, elles sont idéales pour la course à pied à petit budget.", "Conçue pour les runners, coureurs de 10km, de semi et de marathon. Elle suit vos statistiques, traite les données et acquiert toutes les informations sur vos performances, votre technique de course, l'historique de vos entraînements et même vos objectifs.", "Nos concepteurs randonneurs ont conçu ce sac à dos NH Arpenaz 500 30 litres pour accompagner vos randonnées à la journée en plaine, forêt ou sur le littoral. Notre motivation ? Vous proposer un sac à dos confortable et très accessoirisé pour profiter de vos randonnées ! Retrouvez une poche pour conserver au frais votre pique-nique et une poche téléphone.");


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

        for ($c = 0; $c < count($myCategories); $c++) { //on créé 3 catégories
            $category = new Category;
            $category
                ->setName($myCategories[$c])
                ->setSlug(strtolower($this->slugger->slug($category->getName())));

            $manager->persist($category);

            if ($category->getName() === "Canoé") {
                //on remplit la catégorie Canoé
                for ($p = 0; $p < count($canoes); $p++) { //à chaque catégorie créée on créé des produits qu'on relie à cette catégorie
                    $product = new Product;
                    $product
                        ->setName($canoes[$p])
                        ->setPrice($faker->price(4000, 20000))
                        ->setSlug(strtolower($this->slugger->slug($product->getName())))
                        ->setCategory($category)
                        ->setShortDescription($descriptionsCanoes[$p])
                        ->setMainPicture($pictureCanoe[$p]);

                    $products[] = $product; //on rajoute un product dans le tableau products, dans le but de 'remplir' une commande

                    $manager->persist($product);
                }
            }

            if ($category->getName() === "Bivouac") {
                //on remplit la catégorie Bivouac
                for ($p = 0; $p < count($bivouac); $p++) { //à chaque catégorie créée on créé des produits qu'on relie à cette catégorie
                    $product = new Product;
                    $product
                        ->setName($bivouac[$p])
                        ->setPrice($faker->price(4000, 20000))
                        ->setSlug(strtolower($this->slugger->slug($product->getName())))
                        ->setCategory($category)
                        ->setShortDescription($descriptionsBivouac[$p])
                        ->setMainPicture($picturesBivouac[$p]);

                    $products[] = $product; //on rajoute un product dans le tableau products, dans le but de 'remplir' une commande

                    $manager->persist($product);
                }
            }

            if ($category->getName() === "Pêche") {
                //on remplit la catégorie Bivouac
                for ($p = 0; $p < count($fishing); $p++) { //à chaque catégorie créée on créé des produits qu'on relie à cette catégorie
                    $product = new Product;
                    $product
                        ->setName($fishing[$p])
                        ->setPrice($faker->price(4000, 20000))
                        ->setSlug(strtolower($this->slugger->slug($product->getName())))
                        ->setCategory($category)
                        ->setShortDescription($descriptionsFishing[$p])
                        ->setMainPicture($picturesFishing[$p]);

                    $products[] = $product; //on rajoute un product dans le tableau products, dans le but de 'remplir' une commande

                    $manager->persist($product);
                }
            }

            if ($category->getName() === "Randonnée") {
                //on remplit la catégorie Bivouac
                for ($p = 0; $p < count($hiking); $p++) { //à chaque catégorie créée on créé des produits qu'on relie à cette catégorie
                    $product = new Product;
                    $product
                        ->setName($hiking[$p])
                        ->setPrice($faker->price(4000, 20000))
                        ->setSlug(strtolower($this->slugger->slug($product->getName())))
                        ->setCategory($category)
                        ->setShortDescription($descriptionsHiking[$p])
                        ->setMainPicture($picturesHiking[$p]);

                    $products[] = $product; //on rajoute un product dans le tableau products, dans le but de 'remplir' une commande

                    $manager->persist($product);
                }
            }
        }

        for ($p = 0; $p < 40; $p++) { //on instancie 40 commandes
            $purchase = new Purchase;
            $purchase
                ->setFullName($faker->name)
                ->setAddress($faker->streetAddress())
                ->setPostCode($faker->postcode())
                ->setCity($faker->city)
                ->setUser($faker->randomElement($users))
                ->setTotalCost(mt_rand(2000, 30000))
                ->setPurchaseDate($faker->dateTimeBetween('-6 months'));

            $selectedProducts = $faker->randomElements($products, mt_rand(2, 8)); //on prend certains produits de la liste qu'on insère dans la commande

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
