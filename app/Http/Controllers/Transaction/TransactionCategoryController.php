<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     this returns categories for an specific transaction
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    	$transaction=Transaction::findOrFail($id);
    	$categories=$transaction->product->categories;
    	return $this->showAll($categories);
        
    }

   
}
