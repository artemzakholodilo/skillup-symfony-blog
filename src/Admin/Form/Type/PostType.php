<?php

namespace App\Admin\Form\Type;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // todo pattern builder
        // todo related entity choices
        $builder
            ->add('title', TextType::class, [])
            ->add('slug', TextType::class, [])
            ->add('body', TextareaType::class, [])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                }
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => function ($tag) {
                    return $tag->getName();
                },
                'multiple' => true
            ])
            /**
             * @todo replace
             */
            ->add('images', FileType::class, array(
                'multiple' => true
            ))
            ->add('add', SubmitType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}