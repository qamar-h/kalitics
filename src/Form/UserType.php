<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom de l\'utilisateur ...',
                    'data-custom-error-css-class' => 'some-css-error-class another-error-class',
                ],
                'label' => 'Nom',
                'required' => false,
            ])
            ->add('firstname',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prénom de l\'utilisateur ...',
                ],
                'label' => 'Prénom',
                'required' => false,
            ])
            ->add('registrationNumber',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Matricule de l\'utilisateur ...',
                ],
                'label' => 'Matricule',
                'required' => false,
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
