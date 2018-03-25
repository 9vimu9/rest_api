<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    protected $dates=['deleted_at'];
    
	const AVAILABLE_PRODUCT='available';
	const UNAVAILABLE_PRODUCT='unavailable';
//status kiyanne product eka avialble da unavilable da kiana eka thiyaganna eka e sadhaha constant dekak hadamu
    protected $fillable=[
    	'name',
    	'description',
    	'quantity',
    	'status',//available unavailable
    	'image',
    	'seller_id'
    ];

    public function isAvailable()
    {
    	return $this->status==Product::AVAILABLE_PRODUCT;
    }

    public function categories()
    {
    	return $this->belongsToMany(Category::class);
    }

    public function seller()
    {
    	return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }

    //rem
}
