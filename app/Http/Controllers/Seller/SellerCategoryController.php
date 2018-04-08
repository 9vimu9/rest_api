<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sellerId)
    {
        $seller=Seller::findOrFail($sellerId);
        $categories=$seller->products()
            ->whereHas('categories')//product ekata category ekak athnam pamanak eeelaga step yanna
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()//ek ek product thula catrgory kihipayak thibiya haki nisa arrya thul arrya lesa category thibiya haka ema nisa arry thul arry lesa category thibiya hadka siyalla ekama arrya ekakata gena ema min sidu we
            ->unique('id')
            ->values()
            ;
        return $this->showAll($categories);

    }

   
}
