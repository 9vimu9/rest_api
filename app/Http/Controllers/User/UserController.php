<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        // return response()->json(['data'=>$users],200);
        //200-ok response
        return $this->showAll($users);

        $users=Users::all();

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
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ];
         $this->validate($request,$rules);
        $data=$request->all();
       
        $data['password']=bcrypt($request->password);
        $data['verified']=User::UNVERIFIED_USER;
        $data['verification_token']=User::generateVerificationCode();
        $data['admin']=User::REGULAR_USER;
        $user=User::create($data);//sends rrequest directly to create modifying some of its values
        // return response()->json(['data'=>$user],201);
        //201 The request has been fulfilled and resulted in a new resource being created
          return $this->showOne($user,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::findOrFail($id);
        // return response()->json(['data'=>$user],200);
          return $this->showOne($user);

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
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $rules=[
            'email'=>'email|unique:users,email,'.$user->id,//api email eka edit nokaloth email eka unique naa kiyala hithala validate fail karanwa ema nisa melesa dammaama $user object eka hara anith ewage email samaga duplicate wenaweadad balanawa
            'password'=>'min:6|confirmed',
            'admin'=>'in:'.User::ADMIN_USER.','.User::REGULAR_USER,//admin kiyana ekata thibenna puluwan values 2n ekak pamanai e value 2 thama methana in:val_1,val_2 lesa dakwanawa
        ];

        if ($request->has('name')) {//name kiyala index ekak athdai baliima 
            $user->name=$request->name;
            # code...
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified=User::UNVERIFIED_USER;
            $user->verification_token=User::generateVerificationCode();
            $user->email=$request->email;
        }

        if ($request->has('password')) {
            $users->password=bcrypt($request->password);
        }

        if ($request->has('admin')) {

            if (!$user->isVerified()) {
                return $this->errorResponse('only verified users can modify the admin field',409);
            }

            $user->admin=$request->admin;
            // 409
            // The request could not be completed due to a conflict with the current state of the resource. This code is only allowed in situations where it is expected that the user might be able to resolve the conflict and resubmit the request. The response body SHOULD include enough information for the user to recognize the source of the conflict. Ideally, the response entity would include enough information for the user or user agent to fix the problem; however, that might not be possible and is not required. 
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('new value and stored value is same ,u nreed to specify diffrent value to updfate',422);
            // To get only modified attributes, you need to use the getDirty() method. isDirty() only shows if there are any modified attributes:
            //api field ekak update karaddi eke thibena value ekama nawatha yawaddi me error eka enna hadanawa

            // The 422 (Unprocessable Entity) status code means the server understands the content type of the request entity (hence a 415(Unsupported Media Type) status code is inappropriate), and the syntax of the request entity is correct (thus a 400 (Bad Request) status code is inappropriate) but was unable to process the contained instructions.
        }
        
        $user->save();

        // return response()->json(['data'=>$user],200);
        return $this->showOne($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();
         // return response()->json(['data'=>$user],200);
        return $this->showOne($user);
    }
}
