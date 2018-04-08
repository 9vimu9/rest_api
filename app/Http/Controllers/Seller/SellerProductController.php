<?php

namespace App\Http\Controllers\Seller;

use App\User;
use App\Seller;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sellerId)
    {
        $seller=Seller::findOrFail($sellerId);
        $products=$seller->products;
        return $this->showAll($products);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$userId)
    {
        $seller=User::findOrFail($userId);//kawadawath sale ekak karapu nathi kenekutath seller kenek wenna puluwan wenne user model eken gaththoth witarai
        $rules=[
            'name'=>'required',
            'description'=>'required',
            'quantity'=>'required|integer|min:1',
            'image'=>'required|image',
        ];
        $this->validate($request,$rules);
        $data=$request->all();
        $data['status']=Product::UNAVAILABLE_PRODUCT;
        $data['image']='2.jpg';
        $data['seller_id']=$seller->id;

        $product=Product::create($data);
        return $this->showOne($product);

        //dan hithenna puluwan ai api product eka productController eke hadanne naththe kiyala
        // ese wanne apita melesa haduwahama product eka aithi mona seller tada kiyanad eka dana ganna puluwan wenwa
        //e kiyane product ekak hadanna seller kenek specify karanna ma wenawa
        //e nisai api product controller eken store EWAth kale

        //product saha seller athara aththe one to many connection ekak enam seller kenek ta godak product jaathi wikunuwath ekama product eka seller la kihipa denek wikunanne naaa
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sellerId,$productId)
    {
        $seller=User::findOrFail($sellerId);
        $product=Product::findOrFail($productId);
        $rules=[
            'quantity'=>'integer|min:1',
            'status'=>'in:'.Product::AVAILABLE_PRODUCT.','.Product::UNAVAILABLE_PRODUCT,
            'image'=>'image',
        ];
        $this->validate($request,$rules);
        $this->checkSeller($seller,$product);

        $product->fill($request->intersect([
            'name',
            'description',
            'quantity'
        ]));

        if ($request->has('status')) {
            $product->status=$request->status;

            if ($product->isAvailable() && $product->categories()->count()==0) {
                return $this->errorResponse('an active product must have at least one catrory',409);
            }

        }

        if ($product->isClean()) {
                return $this->errorResponse('you didnt enter any new value',409);
        }

        $product->save();
        return $this->showOne($product);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($SellerId,$productId)
    {
        
    }

    protected function checkSeller(User $seller,Product $product)
    {
        if ($seller->id!=$product->seller_id) {
            throw new HttpException("specified seller is not actualseller of product", 422);
            
        }
    }

}
