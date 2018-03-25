<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

	protected $dates=['deleted_at'];

    protected $fillable=[
    	'name',
    	'description'
    ];//user form eken ewan values thama methanata danne fk wage ekak api ne daanne ewa fillable walata dane naa

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }
}
