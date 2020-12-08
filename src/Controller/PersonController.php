<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonFilterType;
use App\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    /**
     * @Route("/users/", name="users")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $filterForm = $this->createForm(PersonFilterType::class, null, [
            'method' => 'GET'
        ]);

        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted()) {
            $filterData = $filterForm->getData();
        }

        $query = $this->getDoctrine()->getRepository(Person::class)->findAllQuery($filterData ?? []);
        $persons = $paginator->paginate($query, $request->query->getInt('page', 1));

        return $this->render('person/index.html.twig', [
            'persons' => $persons,
            'filterForm' => $filterForm->createView()
        ]);
    }

    /**
     * @Route("/persons/search/", name="person_search")
     */
    public function search(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(Person::class)->search($request->query->all());

        $data = [];

        foreach ($products as $product){
            $data[] = [
                'id' => $product->getId(),
                'text' => $product->getLogin(),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/users/add", name="user_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();

            $entityManager->persist($person);
            $entityManager->flush();

            $this->addFlash('success', 'Użytkownik został dodany');
            return $this->redirectToRoute('user_edit', ['id' => $person->getId()]);
        }

        return $this->render('person/edit.html.twig', [
            'form' => $form->createView(),
            'person' => $person
        ]);
    }

    /**
     * @Route("/users/{id}/", name="user_edit")
     */
    public function edit(Request $request, Person $person, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(PersonType::class, $person);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();

            $entityManager->persist($person);
            $entityManager->flush();

            $this->addFlash('success', 'Dane zostały zapisane');
            return $this->redirectToRoute('user_edit', ['id' => $person->getId()]);
        }

        return $this->render('person/edit.html.twig', [
            'form' => $form->createView(),
            'person' => $person
        ]);
    }

    /**
     * @Route("/users/{id}/delete/", name="user_delete")
     */
    public function delete(Request $request, Person $person, EntityManagerInterface $entityManager)
    {
        $person->setState(Person::STATE_DELETED);
        $entityManager->persist($person);
        $entityManager->flush();

        $this->addFlash('success', 'Użytkownik został oznaczony jako usunięty');

        return $this->redirectToRoute('users');
    }
}