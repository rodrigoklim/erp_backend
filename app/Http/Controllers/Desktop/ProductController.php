<?php

namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use App\Models\NcmList;
use App\Models\Products;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showProducts()
    {
        $products = Products::get();

        return $products;
    }

    public function listNcm(Request $request)
    {
        $ncmList = NcmList::get()->pluck('ncm');

        return $ncmList;
    }

    public function createProduct(Request $request, ProductService $productService)
    {
        $product = $productService->handleNewProductRegister($request->params['form']);

        return $product;
    }

    public function editProduct(Request $request, ProductService $productService)
    {
        $editProduct = $productService->handleEditProduct($request->params['product']);

        return $editProduct;
    }
}
