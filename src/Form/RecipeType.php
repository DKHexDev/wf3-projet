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
                    'Hiver' => 'winter',
                    'Printemps' => 'spring',
                    'Été' => 'summer',
                    'Automne' => 'autumn'
                ]
            ])

            // Évènement de la recette.
            ->add('event',  ChoiceType::class, [
                'label' => 'Évènement',
                'choices' => [
                    'Fêtes de fin d\'année' => 'chistmas',
                    'Pâques' => 'easter',
                    'Halloween' => 'halloween',
                    'Anniversaire' => 'bday',
                    'Saint-Valentin' => 'valentineday',
                ]
            ])

            // Culture de la recette.
            ->add('culture',  ChoiceType::class, [
                'label' => 'Culture',
                'choices' => [
                    'Africaine' => 'african',
                    'Américaine'=> 'american',
                    'Asiatique' => 'asia',
                    'Française' => 'france',
                    'Italienne' => 'italian',
                    'Méxicaine' => 'mexican'
                ]
            ])

            // Type de recette.
            ->add('type',  ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Entrée' => 'starter',
                    'Plat' => 'dish',
                    'Dessert' => 'dessert'
                ]
            ])
            // Image de couverture.
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de couverture'
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
