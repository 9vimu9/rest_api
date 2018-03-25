<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($buyerId)
    {
         $buyer=Buyer::findOrfail($buyerId);
     
        // return $buyer;
        $categories=$buyer->transactions()->with('product.categories')//check er diagram
        //with thulata daanne apiproduct saha categories athra model sambanda wana aakrayata anuwa product model eke thiyenne [public function categories()] lesa ema nisa product.categories lesa yodanawa 
            ->get()
            ->pluck('product.categories')//athulata athulata gihin ganna oni nisa
            ->collapse()//product saha category athara athi many to many relationshipo eka nisa mehema sidhu wenwa
            ->unique('id')
            ->values()
            ;
        return $this->showAll($categories);
        // return 'ddd';
    }

    
}


// collapse()

// The collapse method collapses a collection of arrays into a single, flat collection:

// $collection = collect([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);

// $collapsed = $collection->collapse();

// $collapsed->all();

// // [1, 2, 3, 4, 5, 6, 7, 8, 9]
