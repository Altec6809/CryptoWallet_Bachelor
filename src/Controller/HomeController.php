<?php

namespace App\Controller;

use App\Repository\MemoRentabilityRepository;
use App\Entity\MemoRentability;
use App\Entity\Transaction;
use App\Form\AddMoneyType;
use App\Repository\TransactionRepository;
use App\Service\CallApiService;
use App\Service\RentabilityDataService;
use DateTime;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public
    function index(TransactionRepository $userRepository, CallApiService $callApiService, MemoRentabilityRepository $memorised)
    {
        // Récupération du taux et de la valeur de la rentabilité du Bitcoin.
        $transactions = $userRepository->findBycryptoName('Bitcoin');
        foreach ($transactions as $transaction) {
            $quantityBitcoin[] = $transaction->getQuantity();
            if (($transaction->getQuantity()) > 0) {

                $cryptoBitcoin[] = $transaction->getCryptoName();
                $rateGainBitcoin[] = (($callApiService->CurrentPriceBitcoin($callApiService) - $transaction->getPrice()) * ($transaction->getQuantity()));

            } else {
                $rateRemoveBitcoin[] = (($callApiService->CurrentPriceBitcoin($callApiService) * ($transaction->getQuantity())));
            }
        }
        if (empty($rateGainBitcoin)):
            $rateGainBitcoin[] = 0;
            $currencyBitcoin = 0;
        else:
            $rateGainBitcoin = array_reverse($rateGainBitcoin);
            $currencyBitcoin = $rateGainBitcoin[0];
        endif;
        if (empty($rateRemoveBitcoin)) :
            $gainBitcoin = array_sum($rateGainBitcoin);
        else:
            $gainBitcoin = (array_sum($rateGainBitcoin) + array_sum($rateRemoveBitcoin));
        endif;


        // Récupération du taux et de la valeur de la rentabilité du l'Ethereum.
        $transactions = $userRepository->findBycryptoName('Ethereum');
        foreach ($transactions as $transaction) {
            $quantityEthereum[] = $transaction->getQuantity();
            if (($transaction->getQuantity()) > 0) {

                $cryptoEthereum[] = $transaction->getCryptoName();
                $rateGainEthereum[] = (($callApiService->CurrentPriceEthereum($callApiService) - $transaction->getPrice()) * ($transaction->getQuantity()));

            } else {
                $rateRemoveEthereum[] = (($callApiService->CurrentPriceEthereum($callApiService) * ($transaction->getQuantity())));
            }
        }
        if (empty($rateGainEthereum)):
            $rateGainEthereum[] = 0;
            $currencyEthereum = 0;
        else:
            $rateGainEthereum = array_reverse($rateGainEthereum);
            $currencyEthereum = $rateGainEthereum[0];
        endif;

        if (empty($rateRemoveEthereum)) :
            $gainEthereum = array_sum($rateGainEthereum);
        else:
            $gainEthereum = (array_sum($rateGainEthereum) + array_sum($rateRemoveEthereum));
        endif;


// Récupération du taux et de la valeur de la rentabilité du Ripple.
        $transactions = $userRepository->findBycryptoName('Ripple');
        foreach ($transactions as $transaction) {
            $quantityRipple[] = $transaction->getQuantity();
            if (($transaction->getQuantity()) > 0) {

                $labels[] = $transaction->getCryptoName();
                $rateGainRipple[] = (($callApiService->CurrentPriceRipple($callApiService) - $transaction->getPrice()) * ($transaction->getQuantity()));

            } else {
                $rateRemoveRipple[] = (($callApiService->CurrentPriceRipple($callApiService) * ($transaction->getQuantity())));
            }
        }
        if (empty($rateGainRipple)):
            $rateGainRipple[] = 0;
            $currencyRipple = 0;
        else:
            $rateGainRipple = array_reverse($rateGainRipple);
            $currencyRipple = $rateGainRipple[0];
        endif;
        $currencyRipple = $rateGainRipple[0];
        if (empty($rateRemoveRipple)) :
            $gainRipple = array_sum($rateGainRipple);
        else:
            $gainRipple = (array_sum($rateGainRipple) + array_sum($rateRemoveRipple));
        endif;
        
        // On additionne toute les rentabilités de chaque crypto pour avoir le total
        $globalGain = $gainRipple + $gainEthereum + $gainBitcoin;
        $globalGain = round($globalGain);
        $dailyResult = $memorised->findAll();
         $dailyResult = end($dailyResult);
        
        if (!empty($dailyResult)) {
            $date = $dailyResult->getdate()->format('d/m/Y');
        }
        if (empty($dailyResult) or date(date('d/m/Y') < $date)) {
            
         // On stocke la valeur total de la rentabilité une fois par jour.
                $entityManager = $this->getDoctrine()->getManager();
                $data = new MemoRentability();
                $data->setbeneficiation($globalGain);
                $data->setDate(new \DateTime());
                $entityManager->persist($data);
                $entityManager->flush();
        }
        return $this->render('home.html.twig', ['currencyBitcoin' => $currencyBitcoin, 'currencyEthereum' => $currencyEthereum, 'currencyRipple' => $currencyRipple, 'globalGain' => $globalGain,]);
    }
}

