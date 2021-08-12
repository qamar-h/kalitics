<?php

namespace App\Form;

use App\Entity\ConstructionSite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{DateType, TextType, IntegerType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConstructionSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label'     => 'Nom',
                'required'  => false,
                'attr'      => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom du chantier ...',
                ],
            ])
            ->add('address',TextType::class, [
                'label'     => 'Adresse',
                'required'  => false,
                'attr'      => [
                    'class' => 'form-control',
                    'placeholder' => 'N° et  nom de la rue du chantier ...',
                ],
            ])
            ->add('postalCode',IntegerType::class, [
                'label'     => 'Code postal',
                'required'  => false,
                'attr'      => [
                    'class' => 'form-control',
                    'placeholder' => 'Code postal du chantier ...',
                ],
            ])
            ->add('city',TextType::class, [
                'label'      => 'Ville',
                'required'   => false,
                'attr'       => [
                    'class' => 'form-control',
                    'placeholder' => 'Ville du chantier ...',
                ],
            ])
            ->add('startDate', DateType::class, [
                'label'     => 'Date de démarrage',
                'widget'    => 'single_text',
                'format'    => 'yyyy-MM-dd',
                'required'  => true,
                'attr'      => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConstructionSite::class,
        ]);
    }
}
