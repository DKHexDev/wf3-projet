<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Form\Type\TagsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Nom de la recette
            ->add('name', TextType::class, [
                'label' => 'Titre de la recette',
                'attr' => [
                    'placeholder' => 'Titre de la recette',
                ]
            ])
            // Description de la recette
            ->add('description', TextareaType::class, [
                'label' => 'Description de la recette',
                'attr' => [
                    'placeholder' => 'Description de la recette',
                ]
            ])
            // Ingrédients de la recette
            ->add('tags', TagsType::class, [
                'label' => 'Ingrédients',
                'constraints' => [
                    new Assert\Count([
                        'min' => 1,
                        'max' => 15
                    ])
                ]
            ])
            // Saison de la recette.
            ->add('season', ChoiceType::class, [
                'label' => 'Saison',
                'choices'  => [
                    'Hiver' => 'Hiver',
                    'Printemps' => 'Printemps',
                    'Été' => 'Été',
                    'Automne' => 'Automne'
                ]
            ])
            // Évènement de la recette.
            ->add('event', TextType::class, [
                'label' => 'Évènement',
                'attr' => [
                    'placeholder' => 'Évènement',
                ]
            ])
            // Image de couverture.
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de couverture',
                'attr' => [
                    'placeholder' => 'Image de couverture'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
