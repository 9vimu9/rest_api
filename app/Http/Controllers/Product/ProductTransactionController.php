<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($productId)
    {
        $product=Product::findOrFail($productId);

        // return $product;
        $transactions=$product->transactions;

        return $this->showAll($transactions);

    }

   
}
