<?php 

namespace App\Traits;//set location where this file located

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
//this trait will generalize all api responses
trait ApiResponser
{
	protected function successResponse($data,$code)
	{
		return response()->json($data,$code);
	}

	protected function errorResponse($message,$code)
	{
		return response()->json(['error'=>$message,'code'=>$code],$code);
	}

	protected function showAll(Collection $collection,$code=200)//meka use wenne controller wala index ekedi
	{
		return $this->successResponse(['data'=>$collection],$code);
	}


	protected function showOne(Model $model,$code=200)//meka use wenne controller wala show function ekedi
	{
		return $this->successResponse(['data'=>$model],$code);
	}




}




 ?>