<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'disabled'=>true
            ])
            ->add('prenom', TextType::class, [
                'disabled'=>true
            ])
            ->add('email')
            //->add('password')
            ->add('niveau', TextType::class, [
                'disabled'=>true
            ])
            ->add('sexe', TextType::class, [
                'disabled'=>true
            ])
            ->add('telephone')
            ->add('roles', CollectionType::class, [
                'label'=>'Rôle',
                'disabled'=>true
            ])
            //->add('token')->set
            ->add('username')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
