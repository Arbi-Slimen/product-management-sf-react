<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Review;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
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
        //insert products and reviews
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

    /**
     * Return products based on pagination and filters
     * @Route("/api/products", name="getProducts", methods={"GET"})
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param SerializerInterface $serializer
     * @param TagAwareCacheInterface $cachePool
     * @return JsonResponse
     */
    public function getProducts(Request $request, ProductRepository $productRepository, SerializerInterface $serializer, TagAwareCacheInterface $cachePool): JsonResponse
    {
        $page = $request->get('page');
        $limit = $request->get('limit');
        $productName = $request->get('productName');
        $category = $request->get('category');
        $price = $request->get('price');

        if (empty($page))
            $page = 1;
        else
            if (!is_numeric($page))
                return new JsonResponse('Error Type Page.', Response::HTTP_BAD_REQUEST, [], true);

        if (empty($limit))
            $limit = 12;
        else
            if (!is_numeric($limit))
                return new JsonResponse('Error Type Limit.', Response::HTTP_BAD_REQUEST, [], true);

        if (empty($price) or $price < 0)
            $price = -1;
        else
            if (!is_numeric($price))
                return new JsonResponse('Error Type Price.', Response::HTTP_BAD_REQUEST, [], true);

        $idCache = "getProducts-" . $page . "-" . $limit . "-" . $productName . "-" . $category . "-" . $price;
        $jsonProductList = $cachePool->get($idCache, function (ItemInterface $item) use ($productRepository, $page, $limit, $productName, $category, $price, $serializer) {
            $item->tag('productsCache');

            //return product list based on pagination and filter
            $productsList = $productRepository->findAndPagination($page, $limit, $productName, $category, $price);
            //return count products totals
            $countProducts = $productRepository->countProducts($productName, $category, $price);

            $context = SerializationContext::create()->setGroups(['getProducts', 'averageScore']);
            return $serializer->serialize(array_merge(['products' => $productsList], ['countProducts' => $countProducts]), 'json', $context);
        });

        return new JsonResponse($jsonProductList, Response::HTTP_OK, [], true);
    }

    /**
     * Return the detailed product sheet
     * @Route("/api/product/{id}", name="getDetailProduct", methods={"GET"} )
     * @param Product $product
     * @param SerializerInterface $serializer
     * @param TagAwareCacheInterface $cachePool
     * @return JsonResponse
     */
    public function getDetailProduct(Product $product, SerializerInterface $serializer, TagAwareCacheInterface $cachePool): JsonResponse
    {
        $idCache = "getDetailProduct-" . $product->getId();

        $jsonProduct = $cachePool->get($idCache, function (ItemInterface $item) use ($product, $serializer) {
            $item->tag('productsCache');
            $context = SerializationContext::create()->setGroups(['getDetailProduct', 'averageScore']);
            return $serializer->serialize($product, 'json', $context);
        });

        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }
}
