<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductController extends AbstractController
{
    /**
     * Import data into the database
     * @Route("/api/products", name="addProducts", methods={"POST"})
     * @param HttpClientInterface $client
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function addProducts(HttpClientInterface $client, EntityManagerInterface $em): JsonResponse
    {
        $response = $client->request('GET', 'https://tech.dev.ats-digital.com/api/products?size=500');
        $content = $response->toArray();

        //insert category
        foreach ($content['products'] as $product) {
            $category = $em->getRepository(Category::class)->findOneBy(['category' => $product['category']]);
            if ($category === null) {
                $category = new Category();
                $category->setCategory($product['category']);
                $em->persist($category);
                $em->flush();
            }
        }
        //insert product and reviews
        foreach ($content['products'] as $product) {
            $prod = new Product();
            $prod->setProductName($product['productName']);
            $prod->setDescription($product['description']);
            $prod->setPrice($product['price']);
            $prod->setImageUrl($product["imageUrl"]);

            $category = $em->getRepository(Category::class)->findOneBy(['category' => $product['category']]);
            $prod->setCategory($category);

            $em->persist($prod);

            foreach ($product['reviews'] as $review) {
                $rev = new Review();
                $rev->setValue($review['value']);
                $rev->setContent($review['content']);
                $rev->setProduct($prod);
                $em->persist($rev);
            }
        }
        $em->flush();

        return new JsonResponse('Products are imported.', Response::HTTP_OK, [], true);
    }
}
