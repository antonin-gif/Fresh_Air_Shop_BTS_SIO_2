<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\CentimesTrnsfor;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\DataTransformer\CentimesTransformer;
use App\Form\Type\PriceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => ['placeholder' => 'Tapez le nom du produit'],
                'required' => false
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description courte',
                'attr' => [
                    'placeholder' => 'Tapez une description assez courte mais parlante pour le visiteur'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix du produit',
                'attr' => [
                    'placeholder' => 'Tapez le prix du produit en €'
                ],
                'divisor' => 100,
                'required' => false
            ])
            ->add('mainPicture', UrlType::class, [
                'label' => 'Image du produit',
                'attr' => ['placeholder' => 'Tapez une URL d\'image']
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'placeholder' => '--Choisir une catégorie--',
                'class' => Category::class, //on ne peut pas afficher un objet catégorie, on affiche que son nom
                'choice_label' => function (Category $category) {
                    return strtoupper($category->getName()); //on affiche en majuscule les categories
                }
            ]);

        // $builder->get('price')->addModelTransformer(new CentimesTransformer);

        // $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
        //     $product = $event->getData();

        //     if ($product->getPrice() !== null) {
        //         $product->setPrice($product->getPrice() * 100);
        //     }
        // });

        //form.pre_set_data juste avant qu'on positonne les données sur le formulaire
        //form.post_set_data juste apres qu'on ait donné les informations et qu'elles soient intégrées au formulaire
        //form.pre_set_data le moment juste avant qu'on ait soumis le formulaire, on est en train d'analyser la requete
        //form.submit on a pris les données de la requête et on les a transformées de facon à pouvoir les intégrer dans le formulaire
        //form.post.submit j'ai pris les infos de la requeté, je les ai retravaillées et intégréées dans l'entité product
        // $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        //     $form = $event->getForm();

        //     /** @var Product */ //on indique à vscode que product est un objet de la classe Product
        //     $product = $event->getData();

        //     //on affiche en euros et non en centimes le prix 
        //     if ($product->getPrice() !== null) {
        //         $product->setPrice($product->getPrice() / 100);
        //     }

        //     // On ne permet pas de changer de catégorie lors de l'edit
        //     if ($product->getId() === null) {
        //          $form->add('category', EntityType::class, [
        //         'label' => 'Catégorie',
        //         'placeholder' => '--Choisir une catégorie--',
        //         'class' => Category::class, //on ne peut pas afficher un objet catégorie, on affiche que son nom
        //         'choice_label' => function (Category $category) {
        //             return strtoupper($category->getName()); //on affiche en majuscule les categories
        //         }
        //     ]);
        //     }
        // });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
