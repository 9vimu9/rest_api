<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //remember
        //saama exception ekakadima render method eka run we e nisa apita ek ek exception warga waladi mokakda karanne kiyana eka gana balanna methanin puluwan

        if ($exception instanceof ModelNotFoundException) {
            //modelnotfound exception eka enne 
            // http://127.0.0.1:8000/buyers/23122 show function ekata system eke nathi id ekakin call kalaamai(23122)
            $modelName=strtolower(class_basename($exception->getModel()));
            return $this->errorResponse($modelName." does not exist",404);
        }


        if ($exception instanceof NotFoundHttpException) {
            // modelnotfound exception eka haa meka athara athi wenasa wanne NotFoundHttpException eka fire wenne api specify nokarapu route ekak request kala witai
            // http://127.0.0.1:8000/buyers/23122 -ModelNotFoundException
            // http://127.0.0.1:8000/buyerss/23122 -NotFoundHttpException
            return $this->errorResponse("the specified url cannot be found",404);
        }


        if ($exception instanceof ValidationException) {
            //validationexception eka fire wenne backend validation varadunaamai api ema validation errors tika json karala nawatha front end ekatama yawanawa frontend dev ta handle karanna
            $errors = $exception->validator->errors()->getMessages();
            return $this->errorResponse($errors, 422);
        }

        if ($exception instanceof AuthenticationException) {
            //log une nathi kenek karana wada walid ena exception
            return $this->errorResponse("unauthenticated", 401);
        }

        if ($exception instanceof AuthorizationException) {
            //log una kenek unath eyaata permission nathnam
            return $this->errorResponse($exception->getMessage(), 403);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            //get method ekakin access karanna oni ekakata post method eken access kalaama ena exception eka
            return $this->errorResponse("the specifi method fir the request is invalid ", 405);
        }

        if ($exception instanceof QueryException) {
            //Qureywxception ekata thama db errors ahu wenne
            $errorCode=$exception->errorInfo[1];//exception eka dd karala balanna
            if ($errorCode==1451) {
                //fk constrain error eke code eka 1451 wenne
                return $this->errorResponse('cannot remove this resource .becaue it related to other resources FK constrain',409);
            }
        }


        if ($exception instanceof HttpException) {
            //onima exception ekak handle karanna
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }


        
        if (config('app.debug')) {
            // debug=true nam athulata awith apita error eka detail pennanawa development phase eke inna nisa error eka indetial dana ganiima itha wadagath
            return parent::render($request, $exception);
        }
        
        //meka tiyenne production mode ekata pamani
        return $this->errorResponse('unexpected exception. try later' ,500);

        
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }


    // protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    // {
    //     $errors = $e->validator->errors()->getMessages();
    //     return $this->errorResponse($errors, 422);
    //     // convertValidationExceptionToResponse function eka api overwrite kala
    // }
}
