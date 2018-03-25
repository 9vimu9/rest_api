<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0');//this disable foreifh key check so we can truncate tables
    	//if we didnt do this thn foreifn key check errror popoup
    	//truncate will reset model(table)
        DB::table('category_product')->truncate();
        Transaction::truncate();
        Category::truncate();
        Product::truncate();
        User::truncate();

        $usersQuantity=1000;
        $categoriesQuantity=30;
        $productsQuantity=1000;
        $transactionsQuantity=1000;

        factory(User::class,$usersQuantity)->create();
        factory(Category::class,$categoriesQuantity)->create();

        // factory(Product::class,$productsQuantity)->create();//mehema dammama category_product poivot eka pirawenne naa

        factory(Product::class,$productsQuantity)->create()->each(//mehema kalaama category_proiduct pivot eka pirenawea
        	function ($product)
        	{
        		$categories=Category::all()->random(mt_rand(1,5))->pluck('id');
        		$product->categories()->attach($categories);//meka thama category_product eka fill karana code eka attach nethod eka
        	}
        ); 
        factory(Transaction::class,$transactionsQuantity)->create();


    }
}
