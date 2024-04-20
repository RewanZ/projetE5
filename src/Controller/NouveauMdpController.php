<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UpdatePasswordType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class NouveauMdpController extends AbstractController
{
    #[Route('/nouveau_mdp/{token}', name: 'app_nouveau_mdp_token')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher,User $user, ObjectManager $entityManager): Response
    {
        $form = $this->createForm(UpdatePasswordType::class, [$user->getPassword(),$user->getConfirmPassword()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $logs = $form->getData();
            $newPassword=$logs["newpassword"];
            $confirmPassword=$logs["confirmPassword"];
            if ($confirmPassword===$newPassword){
                $user->setPassword($passwordHasher->hashPassword($user, $confirmPassword));
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_login');
            }
            else{
                $this->addFlash('danger','Le mot de passe entrée dans les deux champs doit être identique.');
            }

        }

        //$user->setPassword($passwordHasher->hashPassword());
        return $this->render('nouveau_mdp/index.html.twig', [
            'token'=>$user->getToken(),
            'form'=>$form->createView()
        ]);
    }
    #[Route('/nouveau_mdp/', name: 'app_nouveau_mdp')]
    public function information(): Response
    {
        return $this->render('nouveau_mdp/envoimail.html.twig');
    }
}
