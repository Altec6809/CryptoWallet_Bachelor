<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\RemoveMoneyType;
use App\Service\CallApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoveMoneyController extends AbstractController
{
    /**
     * @Route("/remove", name="rmMoney")
     */
    public function removeMoney(Request $request, CallApiService $callApiService): Response
    {
        $dataApi = $callApiService->callAPI();
        $transaction = new Transaction();
        $form = $this->createForm(RemoveMoneyType::class, $transaction);
        $form->handleRequest($request);


        $transaction->setDate((new \DateTime()));
        $em = $this->getDoctrine()->getManager();
        //  dd($Crypto = $form->getdata());
        $Crypto = $form['cryptoName']->getdata();
        $CryptoQuantity = $form['quantity']->getdata();
        $CryptoQuantityRemove = -$CryptoQuantity;
        $RateBitcoin = $callApiService->CurrentPriceBitcoin($callApiService);
        $RateEthereum = $callApiService->CurrentPriceEthereum($callApiService);
        $RateRipple = $callApiService->CurrentPriceRipple($callApiService);

        switch ($Crypto) {
            case 'Bitcoin':
                $transaction->setPrice($RateBitcoin);
                break;
            case 'Ethereum':
                $transaction->setPrice($RateEthereum);
                break;
            case 'Ripple':
                $transaction->setPrice($RateRipple);
                break;
        }

        $transaction->setQuantity($CryptoQuantityRemove);

        //   );

        // }
        dump($form['quantity']->getdata());
        if ($form->isSubmitted() && $form['quantity']->getdata() >= 0.001) {
            $em->persist($transaction);
            $em->flush();
            $this->addFlash('success', 'Montant supprimé. Le nouveau solde de votre rentabilité est :');
            return $this->redirectToRoute('home');
        }


        return $this->render('removeMoney.html.twig', [
            'form' => $form->createView()

        ]);

    }
}