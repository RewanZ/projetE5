<?php

namespace App\Controller;

use App\Repository\DemandeRepository;
use App\Repository\SoutienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(ChartBuilderInterface $chartBuilder, SoutienRepository $soutienRepository, DemandeRepository $demandeRepository): Response
    {

        $chartNbDemande = $chartBuilder->createChart(Chart::TYPE_BAR);
        $results = $soutienRepository->countSoutiensForMonth();
        //dd($lesDemandesNonSoutenus);
        $data = [];
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
        $chartNbDemande->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Nombre de soutien par mois',
                    'backgroundColor' => 'rgb(0, 204, 224)',
                    'borderColor' => 'rgb(247, 255, 99)',
                    'data' => $datas,

            ],
                ]])
      ;

        $chartNbDemande->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($datas)+10,
                ],
            ],
        ]);


        $lesDemandesNonSoutenus=$demandeRepository->findDemandesWithStatusNotIn();
        //dd($lesDemandesNonSoutenus);
        $chartDemandeNonSoutenu = $chartBuilder->createChart(Chart::TYPE_LINE);
        //$results = $soutienRepository->countSoutiensForMonth();
        //dd($lesDemandesNonSoutenus);
        $data = [];
        //dd($lesDemandesNonSoutenus);
        foreach ($lesDemandesNonSoutenus as $result) {

            $data[] = [
                'month' => $result['month'],
                'count' => $result['count'],
            ];
            //$total+=$result['count'];


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
        $chartDemandeNonSoutenu->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Nombre de Demande Non Soutenus',
                    'backgroundColor' => 'rgb(6, 238, 76)',
                    'borderColor' => 'rgb(0, 204, 224 )',
                    'data' => $datas,

                ],
            ]])
        ;

        $chartDemandeNonSoutenu->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($datas)+5,
                ],
            ],
        ]);
        return $this->render('chart/index.html.twig', [
            'chart' => $chartNbDemande,
            'total'=>$total,
            'chartDemandeNonSoutenu'=>$chartDemandeNonSoutenu
        ]);
    }
}
