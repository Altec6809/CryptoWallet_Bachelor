<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\AddMoneyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddMoneyController extends AbstractController
{
    /**
     * @Route("/add-Money", name="addMoney")
     */
    public function addTransaction(Request $request)
    {

        $transaction = new Transaction();
        $form = $this->createForm(AddMoneyType::class, $transaction);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setDate((new \DateTime()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();
            $this->addFlash('success', "Transaction ajoutée. Le nouveau solde de votre rentabilité est :");
            return $this->redirectToRoute('home');
        }


        return $this->render('addMoney.html.twig', [
            'form' => $form->createView()

        ]);
    }
}