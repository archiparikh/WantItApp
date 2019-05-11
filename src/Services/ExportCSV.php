<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportCSV
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function exportAllProducts()
    {
        $repository = $this->productRepository;
        $response = new StreamedResponse();
        $response->setCallback(function() use ($repository) {
            $handle = fopen('php://output', 'w+');
            fputcsv($handle, ['name', 'description', 'price'], ";");

            $products = $repository->findAllSortByName();
            foreach ($products as $product) {
                fputcsv(
                    $handle,
                    [$product->getName(), $product->getDescription(), $product->getPrice()],
                    ';'
                );
            }
            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition','attachment; filename="export-products.csv"');

        return $response;
    }
}