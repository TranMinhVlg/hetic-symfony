<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Form\ExpenseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExpensesController extends Controller
{
    /**
     * @Route("/expenses", name="expenses")
     */
    public function index()
    {
        if ( ! $this->getUser()) {
            throw $this->createNotFoundException('The user is not logged');
        }
        $expenses = $this->getUser()->getExpenses();

        $highestExpense = $this->getDoctrine()->getRepository(Expense::class)->findUserHighestExpense($this->getUser());
        $totalExpenses  = $this->getDoctrine()->getRepository(Expense::class)->findUserTotalExpense($this->getUser());

        return $this->render('expenses/index.html.twig',
            ['expenses' => $expenses, 'highestExpense' => $highestExpense, 'totalExpenses' => $totalExpenses]);
    }

    /**
     * @Route("/expenses/new", name="expenses_new")
     */
    public function create(Request $request)
    {
        $expense = new Expense();
        $form    = $this->createForm(ExpenseType::class, $expense);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            $expense = $expense->setUserId($this->getUser());
            $em      = $this->getDoctrine()->getManager();
            $em->persist($expense);
            $em->flush();
            unset($comment);
            unset($form);
            $entity = new Expense();
            $form   = $this->createForm(ExpenseType::class, $entity);

            $this->addFlash(
                'notice',
                'Dépense ajoutée avec succès !'
            );
        }

        return $this->render('expenses/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
