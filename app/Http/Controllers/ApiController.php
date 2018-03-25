<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class ApiController extends Controller
{
    use ApiResponser;//memagin trait eke thiyena function okkoma ApiController classs ekata genaawa dan ApiController eke child class hama ekakatama e function walata access thiywenawaBuyerController,ProdcutController .... etc
}
