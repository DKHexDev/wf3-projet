<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de la recette',
                'attr' => [
                    'placeholder' => 'Titre de la recette',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la recette',
                'attr' => [
                    'placeholder' => 'Description de la recette',
                ]
            ])
            //->add('ingredients', TextareaType::class, [
            //    'label' => 'Ingrédients'
            //])
            ->add('season', TextType::class, [
                'label' => 'Saison',
                'attr' => [
                    'placeholder' => 'Saison',
                ]
            ])
            ->add('event', TextType::class, [
                'label' => 'Évènement',
                'attr' => [
                    'placeholder' => 'Évènement',
                ]
            ])
            //->add('background')
            //->add('slug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}