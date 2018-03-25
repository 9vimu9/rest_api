<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($buyerId)
    {
        $buyer=Buyer::findOrfail($buyerId);
        $products=$buyer->transactions()->with('product')->get()
                        ->pluck('product')
                        ;
        return $this->showAll($products);
    }

   
}

//remember

// er digram salakamu

// Buyer 1:m Transaction m:1 Product

// apita Buyer kenek gaththa product warga monada kiyala ganna oni kiyala hithamu
// $products=$buyer->transactions->product;
// lesa liwwata enne naa mokada  Buyer 1:m Transaction wana nisai enam $buyer->transactions waladi return wenne eka transaction ekak neme collection of transactions mokada one to many relationship ekak thiyenne Buyer saha Transaction athare elesa collection ekak return unaama ewani ekakata ->product lesa araganna baa
// e sadhaha eager loading yoda gannawa

//  $products=$buyer->transactions()->with('product')->get();

//  dan buyer ge saama transaction ekak thulatama gihin ewage athi product okkoma ekakata ekathu karala eka retrurn karanawa

// {
//     "data": [
//         {
//             "id": 218,
//             "quantity": 2,
//             "buyer_id": 2,
//             "product_id": 727,
//             "created_at": "2018-03-25 16:08:21",
//             "updated_at": "2018-03-25 16:08:21",
//             "deleted_at": null,
//             "product": {
//                 "id": 727,
//                 "name": "voluptatum",
//                 "description": "Dicta aspernatur doloribus et eveniet corrupti esse totam.",
//                 "quantity": 9,
//                 "status": "available",
//                 "image": "2.jpg",
//                 "seller_id": 492,
//                 "created_at": "2018-03-25 16:05:43",
//                 "updated_at": "2018-03-25 16:05:43",
//                 "deleted_at": null
//             }
//         }
//     ]
// }
// mehi product eka pawathinne transaction eka thulai ema nisa 

//  $products=$buyer->transactions()->with('product')->get()->pluck('product');//index of product


// {
//     "data": [
//         {
//             "id": 727,
//             "name": "voluptatum",
//             "description": "Dicta aspernatur doloribus et eveniet corrupti esse totam.",
//             "quantity": 9,
//             "status": "available",
//             "image": "2.jpg",
//             "seller_id": 492,
//             "created_at": "2018-03-25 16:05:43",
//             "updated_at": "2018-03-25 16:05:43",
//             "deleted_at": null
//         }
//     ]
// }