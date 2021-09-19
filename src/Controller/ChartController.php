<?php

namespace App\Controller;

use App\Repository\MemoRentabilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartController extends AbstractController
{
    /**
     * @Route("/chart", name="chart")
     */

    public function index(MemoRentabilityRepository $memoRepository, ChartBuilderInterface $chartBuilder): Response
    {

        $dailyResults = $memoRepository->findAll();

        foreach ($dailyResults as $dailyResult) {
            $labels[] = $dailyResult->getDate()->format('d/m/Y');
            $data[] = $dailyResult->getBeneficiation();
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([

            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Daily evolution',
                    'borderColor' => '#1fc36c',
                    'data' => $data,

                ],
            ],
        ]);

        return $this->render('chart.html.twig', [
            'chart' => $chart,
        ]);
    }
}



