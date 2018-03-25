<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($buyerId)
    {
       $buyer=Buyer::findOrFail($buyerId);
       $transactions=$buyer->transactions;
       return $this->showAll($transactions);

    }

   
}
