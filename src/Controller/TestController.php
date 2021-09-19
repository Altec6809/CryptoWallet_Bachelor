<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Service\CallApiService;
use App\Service\RentabilityDataService;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

;

class TestController extends AbstractController
{
    /**
     * @Route("/test")
     */


    public
    function gainBitcoin(TransactionRepository $transactionRepository, CallApiService $callApiService, RentabilityDataService $rentabilityDataService): Response
    {

        dd($rentabilityDataService->Rentability());


        return new Response;
    }
}