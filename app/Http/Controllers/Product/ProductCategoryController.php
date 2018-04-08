<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($productId)
    {
        // return 5;
        //this will show categoreis of selected product
        $product=Product::findOrFail($productId);
        $categories=$product->categories;
        return $this->showAll($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productId,$categoryId)
    {
        //rem
        //methanin wenne pivot table ekata store karana hati.prodcut ekakata aluthin category ekak daanna yanne
        //for intercat with many to many relationships we use attach, sync, syncwitoutdetaching
        // attach->add new category for product and it can add same category twice
        //sync->add new category for product and delete other categories of it
        //syncwithoutatdetaching->add new cat5egory for product cant add same category for one product twice
        $product=Product::findOrFail($productId);
        $category=Category::findOrFail($categoryId);

        $product->categories()->syncwithoutDetaching([$category->id]);
        //syncWithoutDetaching([id_1,id_2,id_3]) lesa godak eka wara daannath puluwn

        $categories=$product->categories;
        return $this->showAll($categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId,$categoryId)
    {
        //remove vategory from selected product
        //api mulinma balanna oni url eken ewana category eka me product eke thiyena category ekakda kiyala

        $product=Product::findOrFail($productId);
        $category=Category::findOrFail($categoryId);

        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('the specified category is not a category of this product',404);
        }
        //product eken category eka remvove karana aakraya
        $product->categories()->detach($category->id);

        $categories=$product->categories;
        return $this->showAll($categories);
        
    }
}
