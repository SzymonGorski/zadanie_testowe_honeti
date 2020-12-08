<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFilterType;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/", name="products")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $filterForm = $this->createForm(ProductFilterType::class, null, [
            'method' => 'GET'
        ]);

        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted()) {
            $filterData = $filterForm->getData();
        }

        $query = $this->getDoctrine()->getRepository(Product::class)->findAllQuery($filterData ?? []);
        $products = $paginator->paginate($query, $request->query->getInt('page', 1));

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'filterForm' => $filterForm->createView()
        ]);
    }


    /**
     * @Route("/products/add", name="product_add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Produkt został dodany');
            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    /**
     * @Route("/products/search/", name="product_search")
     */
    public function search(Request $request)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->search($request->query->all());

        $data = [];

        foreach ($products as $product){
            $data[] = [
                'id' => $product->getId(),
                'text' => $product->getName(),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/products/{id}/", name="product_edit")
     */
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Dane zostały zapisane');
            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

    /**
     * @Route("/products/{id}/delete/", name="product_delete")
     */
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('success', 'Produkt został usunięty');

        return $this->redirectToRoute('products');
    }
}