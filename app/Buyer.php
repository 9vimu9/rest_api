<?php

namespace App;

use App\Transaction;
use App\User;

class Buyer extends User//Buyer th user kenek system eke widihjata e nisa user wa extend karanwea
{
    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }
}
