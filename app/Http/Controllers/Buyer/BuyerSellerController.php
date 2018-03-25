<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
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
        $sellers=$buyer->transactions()->with('product.seller')
            ->get()
            ->pluck('product.seller')//athulata athulata gihin ganna oni nisa
            ->unique('id')
            ->values()
            ;
        return $this->showAll($sellers);
        // return 'ddd';
    }

    
}
