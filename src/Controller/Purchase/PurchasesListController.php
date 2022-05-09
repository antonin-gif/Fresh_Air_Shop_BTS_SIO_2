<?php

namespace App\Controller\Purchase;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasesListController extends AbstractController
{

    /**
     * @Route("/purchases", name="purchase_index")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour accéder à vos commandes")
     */
    public function index()
    { //liste les commandes de l'user actuel

        //1. On s'assure que la personne est connectée, sinon on la redirection vers page d'accueil -> Security
        /** @var User */
        $user = $this->getUser();

        //2. On veut savoir qui est connecté -> Security
        //3. On passe l'user connecté à twig afin d'afficher ses commandes -> Environment de twig/response
        return $this->render('purchase/index.html.twig', [
            'purchases' => $user->getPurchases()
        ]);
    }
}
