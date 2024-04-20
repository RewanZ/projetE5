<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('newpassword', PasswordType::class,
            [
                'label'=>'Entrez un mot de passe :',
                'constraints'=>[
                    new NotBlank(null,'Merci d\'entrer un mot de passe')
                ]
            ])
            ->add('confirmPassword', PasswordType::class,
                [
                    'label'=>'Confirmer votre mot de passe :',
                    'constraints'=>[
                        new NotBlank(null,'Merci de confirmer votre mot de passe')
                    ]
                ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
