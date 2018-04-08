<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId)
    {
        $category=Category::findOrFail($categoryId);
        $transactions=$category->products()
                        ->whereHas('transactions')
                        ->with('transactions')
                        ->get()
                        ->pluck('transactions')
                        ->collapse();

        return $this->showAll($transactions);


// relationship between treansaction and product
// transaction m:1 product 

// enam saama transaction ekaktama product ekak aniwaryen pawathi 
// namuth 
// saama product ekakatama transaction 
//     kisiwak nopawathi,
//     ekak pawathi ,
//     bohomayak pawathiya haka 

// product ekakata kisima transaction ekak nopwathin witaka
// $transactions=$category->products()->with('transactions');
// lesa ganiimata nohaki we.
// mokada product ekata adaalwa transaction ekak nothibiya haki nisaya. 
// ema nisa
// ->whereHas('transactions')
// yodanwaw emagin product ekata transaction ekak thibeda kiyala mulinma balanwawa
// athi nam pamak product ekata adaala transacrion wlata accesss karanwa
    }

    
}
