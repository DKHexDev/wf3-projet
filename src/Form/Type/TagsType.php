<?php
namespace App\Form\Type;

use App\Form\DataTransformer\TagsTransformer;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class TagsType extends AbstractType
{

    /**
     * @var ObjectManager
     */
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CollectionToArrayTransformer(), true)
                ->addModelTransformer(new TagsTransformer($this->manager), true);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('attr', [
            'id' => 'recipe_tags',
            'class' => 'tag-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50',
            'placeholder' => 'Ingrédients'
        ]);
        $resolver->setDefault('required', true);
        
    }

    // Le parent de TagsType
    public function getParent() {
        return TextType::class;
    }



}