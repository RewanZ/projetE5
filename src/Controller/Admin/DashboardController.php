<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use App\Entity\Demande;
use App\Entity\Matiere;
use App\Entity\Salle;
use App\Entity\User;
use App\Repository\DemandeRepository;
use App\Repository\SoutienRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


#[Route('/admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator, private SoutienRepository $soutienRepository, private ChartBuilderInterface $chartBuilder, private DemandeRepository $demandeRepository)
    {}

    #[Route('/', name: 'admin_home')]
    public function index(): Response
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $results = $this->soutienRepository->countSoutiensForMonth();

        $total=0;

        foreach ($results as $result) {

            $data[] = [
                'month' => $result['month'],
                'count' => $result['count'],
            ];
            $total+=$result['count'];

        }
        $datas=[

            $data[0]["count"] ,
            $data[1]["count"],
            $data[2]["count"],
            $data[3]["count"],
            $data[4]["count"],
            $data[5]["count"],
            $data[6]["count"],
            $data[7]["count"],
            $data[8]["count"],
            $data[9]["count"],
            $data[10]["count"],
            $data[11]["count"],
        ];
        //dd($data[2]);
        $chart->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Nombre de soutien par mois',
                    'backgroundColor' => 'rgb(0, 204, 224)',
                    'borderColor' => 'rgb(247, 255, 99)',
                    'data' => $datas,

                ],
            ]]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($datas)+10,
                ],
            ],
        ]);




        $chart2 = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $results = $this->soutienRepository->countSoutiensForMonth();


        foreach ($results as $result) {

            $data[] = [
                'month' => $result['month'],
                'count' => $result['count'],
            ];

        }
        $datas=[

            $data[0]["count"] ,
            $data[1]["count"],
            $data[2]["count"],
            $data[3]["count"],
            $data[4]["count"],
            $data[5]["count"],
            $data[6]["count"],
            $data[7]["count"],
            $data[8]["count"],
            $data[9]["count"],
            $data[10]["count"],
            $data[11]["count"],
        ];
        //dd($data[2]);
        $chart->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Nombre de soutien par mois',
                    'backgroundColor' => 'rgb(0, 204, 224)',
                    'borderColor' => 'rgb(247, 255, 99)',
                    'data' => $datas,

                ],
            ]]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($datas)+10,
                ],
            ],
        ]);
        return $this->render('admin/index.html.twig', [
            'chart'=>$chart,
            'total'=>$total,
        ]);
    }

    #[Route('/salle', name: 'admin_salle')]
    public function salle(): Response
    {
        $url=$this->adminUrlGenerator->setController(SalleCrudController::class)->generateUrl();


        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }
    #[Route('/demande', name: 'admin_demande')]
    public function demande(): Response
    {
        $url=$this->adminUrlGenerator->setController(DemandeCrudController::class)->generateUrl();
        return $this->redirect($url);
    }
    #[Route('/demande', name: 'admin_demande')]
    public function classe(): Response
    {
        $url=$this->adminUrlGenerator->setController(ClasseCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('HelpORT ');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter/Modifier une salle','fas fa-plus', Salle::class)->setAction(Crud::PAGE_INDEX),
            MenuItem::linkToCrud('Ajouter/Modifier une demande','fas fa-plus', Demande ::class)->setAction(Crud::PAGE_INDEX),
            MenuItem::linkToCrud('Ajouter/Modifier une classe','fas fa-plus', Classe ::class)->setAction(Crud::PAGE_INDEX),
            MenuItem::linkToCrud('Ajouter/Modifier une matière','fas fa-plus', Matiere ::class)->setAction(Crud::PAGE_INDEX),
            MenuItem::linkToCrud('Ajouter/Modifier un utilisateur','fas fa-plus', User ::class)->setAction(Crud::PAGE_INDEX),




        ]);
    }

    public function configureAssets(): Assets
    {
        $assets = parent::configureAssets();

        $assets->addWebpackEncoreEntry('app');

        return $assets;
    }
}
