<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchIdeaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('mostCommented', SubmitType::class, [
                'label' => '10 most commented ideas',
                'attr' => [
                'class' => "filter btn-success btn-block" ]
                ])
                ->add('mostLiked', SubmitType::class, [
                    'label' => '10 most liked ideas',
                    'attr' => [
                    'class' => "filter btn-success btn-block" ]
                ])
                ->add('myLiked', SubmitType::class, [
                    'label' => 'ideas I like',
                    'attr' => [
                    'class' => "filter btn-success btn-block" ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
