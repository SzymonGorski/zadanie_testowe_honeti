<?php

namespace App\Controller;

use App\Entity\PersonLikeProduct;
use App\Form\PersonLikeProductFilterType;
use App\Form\PersonLikeProductType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/likes/", name="likes")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
       $filterForm = $this->createForm(PersonLikeProductFilterType::class, null, [
            'method' => 'GET'
        ]);

        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted()) {
            $filterData = $filterForm->getData();
        }

        $query = $this->getDoctrine()->getRepository(PersonLikeProduct::class)->findAllQuery($filterData ?? []);
        $personLikeProducts = $paginator->paginate($query, $request->query->getInt('page', 1));

        return $this->render('like/index.html.twig', [
            'personLikeProducts' => $personLikeProducts,
            'filterForm' => $filterForm->createView()
        ]);
    }

    /**
     * @Route("/likes/add/", name="like_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $personLikeProduct = new PersonLikeProduct();
        $form = $this->createForm(PersonLikeProductType::class, $personLikeProduct);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personLikeProduct = $form->getData();

            try {
                $entityManager->persist($personLikeProduct);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Taka polubienie już istnieje');
                return $this->redirectToRoute('like_add');
            }

            $this->addFlash('success', 'Polubienie zostało dodany');
            return $this->redirectToRoute('like_edit', ['person_id' => $personLikeProduct->getPerson()->getId(), 'product_id' => $personLikeProduct->getProduct()->getId()]);
        }

        return $this->render('like/edit.html.twig', [
            'form' => $form->createView(),
            'personLikeProduct' => $personLikeProduct
        ]);
    }

    /**
     * @Route("/likes/{person_id}/{product_id}/", name="like_edit")
     */
    public function edit(Request $request, $person_id, $product_id, EntityManagerInterface $entityManager)
    {
        $personLikeProduct = $entityManager->getRepository(PersonLikeProduct::class)->findOneBy([
            'product' => $product_id,
            'person' => $person_id,
        ]);

        $form = $this->createForm(PersonLikeProductType::class, $personLikeProduct);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $personLikeProduct = $form->getData();

            try {
                $entityManager->persist($personLikeProduct);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Taka polubienie już istnieje');
                return $this->redirectToRoute('like_edit', ['person_id' => $personLikeProduct->getPerson()->getId(), 'product_id' => $personLikeProduct->getProduct()->getId()]);
            }

            $this->addFlash('success', 'Dane zostały zapisane');
            return $this->redirectToRoute('like_edit', ['person_id' => $personLikeProduct->getPerson()->getId(), 'product_id' => $personLikeProduct->getProduct()->getId()]);
        }

        return $this->render('like/edit.html.twig', [
            'form' => $form->createView(),
            'personLikeProduct' => $personLikeProduct
        ]);
    }

    /**
     * @Route("/likes/{person_id}/{product_id}/delete/", name="like_delete")
     */
    public function delete(Request $request, $person_id, $product_id, EntityManagerInterface $entityManager)
    {
        $personLikeProduct = $entityManager->getRepository(PersonLikeProduct::class)->findOneBy([
            'product' => $product_id,
            'person' => $person_id,
        ]);

        $entityManager->remove($personLikeProduct);
        $entityManager->flush();

        $this->addFlash('success', 'Polubienie zostało usunięte');

        return $this->redirectToRoute('likes');
    }
}