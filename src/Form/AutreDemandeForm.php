<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Matiere;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutreDemandeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('date_updated')
            ->add('date_fin_demande', DateType::class,
                [
                    'disabled'=>true
                ])
            ->add('status', EntityType::class, [
                    'class'=>Matiere::class,
                    'choice_label' => 'status',
                    'choice_name'=>'status'
                ]
            )
            ->add('id_user', EntityType::class,
            [
                'class'=>User::class,
                'disabled'=>true
            ])
            ->add('id_matiere', EntityType::class,
                [
                    'class'=>Matiere::class,
                    'disabled'=>true
                ])
            ->add('sous_Matiere',TextType::class,
                [
                    //'class'=>Matiere::class,
                    'disabled'=>true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
