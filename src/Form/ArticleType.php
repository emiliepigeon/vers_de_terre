<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug'
            ])
            ->add('texte', TextType::class, [
                'label' => 'Texte'
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image (JPEG, PNG, ...)',
                'required' => false,
            ])
            ->add('category') // Assurez-vous d'ajouter le champ pour la catégorie
            ->add('author', TextType::class, [
                'label' => 'Auteur'
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publié',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
