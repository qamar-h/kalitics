<?php

namespace App\Form;

use App\Entity\CheckIn;
use App\Entity\ConstructionSite;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckInType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('constructionSite', EntityType::class, [
                'label'     => 'Chantier',
                'class' => ConstructionSite::class,
                'choice_label' => 'name',
                'required'  => false,
                'attr'      => [
                    'class' => 'form-control',
                ],
            ])
            ->add('user', EntityType::class, [
                'label'     => 'Utilisateur',
                'class' => User::class,
                'choice_label' => function($user) {
                    return $user->getFirstname() . ' ' . $user->getLastname();
                },
                'required'  => false,
                'attr'      => [
                    'class' => 'form-control',
                ],
            ])
            ->add('dateOfCheckIn', DateType::class, [
                'label'     => 'Date du pointage',
                'widget'    => 'single_text',
                'format'    => 'yyyy-MM-dd',
                'required'  => true,
                'attr'      => [
                    'class' => 'form-control',
                ],
            ])
            ->add('duration',IntegerType::class, [
                'label'     => 'Durée (minute)',
                'required'  => false,
                'attr'      => [
                    'class' => 'form-control',
                    'placeholder' => 'Durée du pointage ...',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CheckIn::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'check_in_form',
            'attr' => [
                'id' => 'check-in-form'
            ]
        ]);
    }
}
