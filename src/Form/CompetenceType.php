<?php

namespace App\Form;

use App\Entity\Competence;
use App\Entity\Matiere;
use App\Entity\SousMatiere;
use App\Repository\MatiereRepository;
use App\Repository\SousMatiereRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class CompetenceType extends AbstractType
{
    private $sousMatiereRepository;
    private $matiereRepository;
    private $security;

    public function __construct(Security $security,  MatiereRepository $matiereRepository)
    {
        $this->security = $security;
        $this->sousMatiereRepository=[];
        $this->matiereRepository = $matiereRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $userId = $user->getId();
        $builder

            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'designation',
                'choice_value' => 'id',
                'placeholder' => 'Veuillez choisir une matière',
                'query_builder' => function (MatiereRepository $matiereRepository) use ($userId) {
                    return $matiereRepository->findMatiereByUserQueryBuilder($userId) ;
                }
            ])
            ->add('send', SubmitType::class)
            ;

        $formModifier = function (FormInterface $form, Matiere $matiere = null) {
            $sousMatieres = $matiere === null ? [] : $this->matiereRepository->findSousMatieresByMatiere($matiere);
            $choices = [];
            foreach ($sousMatieres as $sousMatiere) {
                $choices[$sousMatiere] = $sousMatiere;
                dump($sousMatiere);
            }
            $form->add('sous_matiere', ChoiceType::class, [
                'disabled' => $matiere === null,
                'placeholder' => 'Veuillez choisir une sous-matière',
                'choices' => $choices,

            ]);
        };


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                //dd($data);

                $formModifier($event->getForm(), $data->getMatiere());
            }
        );

        $builder->get('matiere')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $matiere = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $matiere);
                dump($formModifier);
            }
        ) ;


    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Demande::class,
            //'matiere'=>$this->matiereRepository->find(1)
        ]);
    }
}
