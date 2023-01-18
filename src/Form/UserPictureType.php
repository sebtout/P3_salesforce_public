<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsFalse;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserPictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profilePictureFile', VichFileType::class, [
                'label' => 'Add your profile picture',
                'attr' => [
                    'placeholder' => 'Name',
                ],
                'required'      => false,
                'allow_delete'  => false, // not mandatory, default is true
                'download_uri' => false, // not mandatory, default is true
                ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add profile picture'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
