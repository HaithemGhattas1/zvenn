<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_produit')
            ->add('descriptionp', TextareaType::class)
            ->add('image_produit', FileType::class, [
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => true
            ])


            ->add('prix_produit')
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'nomtype'
            ])
            ->add('type_produit', ChoiceType::class, [
                'choices'  => [
                    'dessert' => 'dessert',
                    'starters' => 'starters',
                    'fastfood' => 'fastfood',

                ]])

        ;


    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
