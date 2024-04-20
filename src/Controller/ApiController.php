<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\User;
use App\Form\VerifApiType;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Studoo\Api\EcoleDirecte\Client;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ApiController extends AbstractController
{
    #[Route('/', name: 'app_api')]
    public function index(Request $request, ObjectManager $entityManager,MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($this->getUser()){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(VerifApiType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $logs = $form->getData();

            $client = new Client([
                "client_id" => $logs['identifiant'],
                "client_secret" => $logs['mot_de_passe'],
                "base_path" => "http://localhost:9042",
                "mock" => true,
            ]);


                try {
                    $etudiant = $client->fetchAccessToken();
                    if ($etudiant) {

                        $user = new User();
                        $profile = $etudiant->getProfile();
                        $telephone = $profile['telPortable'];
                        if(!isset($profile['sexe'])){
                            $sexe=3;
                        }
                        else{
                            $sexe = $profile['sexe'];
                        }

                        $token = $tokenGenerator->generateToken();

                        $uneClasse = $etudiant->getClasse();
                       $laClasse=$uneClasse[0]['code'];
                        $classeRepository = $entityManager->getRepository(Classe::class);
                        $classe=$classeRepository->findOneBy(['nom'=>$laClasse]);
                        //dd($classe);

//                        foreach ($laClasse as $libelle) {
//                            $niveau = $libelle['code'];
//                        }
//
//                        $classeRepository = $entityManager->getRepository(Classe::class);
//
//                        $existingClasse = $classeRepository->findOneBy(['nom' => $niveau]);
//
//                        if (!$existingClasse) {
//                            $classe = new Classe();
//                            $classe->setNom($niveau);
//                            $classe->setCode(100);
//                            $entityManager->persist($classe);
//                        } else {
//                            $classe = $existingClasse;
//
//                        }

                        $username = $etudiant->getIdentifiant();

                        $userRepository = $entityManager->getRepository(User::class);
                        $existingUser = $userRepository->findOneBy(['username' => $username]);

                        if ($existingUser) {
                             $this->addFlash('info', 'votre compte a déjà été inscrit');
                            //$this->addFlash('info', 'Votre compte a déjà été inscrit');
                            return $this->redirectToRoute('app_login');
                        }
                        else
                        {
                            $user->setUsername($etudiant->getIdentifiant());
                            $user->setSexe($sexe == 'M' ? 1 : 2);
                            $user->setNom($etudiant->getNom());
                            $user->setPrenom($etudiant->getPrenom());
                            $user->setEmail($etudiant->getEmail());
                            $user->setTelephone($telephone);
                            $user->setNiveau($laClasse);
                            $user->setClasse($classe);
                            $user->setToken($token);
                            $random = random_bytes(10);
                            $user->setPassword($passwordHasher->hashPassword($user, $random));
                            $user->setRoles([$etudiant->getTypeCompte() == 'E' ? 'ROLE_USER' : 'ROLE_ADMIN']);
                            //->setRoles;

                            //dd($etudiant->getTypeCompte() == 'E' ? 'ROLE_USER' : 'ROLE_ADMIN');
                            $entityManager->persist($user);

                            $entityManager->flush();

                            $link = $this->generateUrl('app_nouveau_mdp_token', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                            $email = (new TemplatedEmail())
                                ->from('HelpORT@ortmontreuil.fr')
                                ->to($etudiant->getEmail())
                                ->subject('Thanks for signing up!')
                                ->htmlTemplate('api/signup.html.twig')
                                ->context([
                                    'expiration_date' => new \DateTime('+10 minutes'),
                                    'username' => 'foo',
                                    'link' => $link,
                                ]);
                            $mailer->send($email);
                            return $this->render('nouveau_mdp/envoimail.html.twig');
                        }

                    }

                }
            catch (\Exception $e) {
                //$this->addFlash('error', $e->getMessage());
                if ($e->getCode()==401){
                    //dd('bnfi');
                    $this->addFlash('danger', 'Les données fournies ne correspondent pas');
                    return $this->redirectToRoute('app_api');
                }
                //dd($e);
                return $this->render('api/index.html.twig', [
                    'message' => 'Une erreur s\'est produite : ' . $e->getMessage(),
                    'form' => $form->createView()
                ]);

            }
        }
        return $this->render('api/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
