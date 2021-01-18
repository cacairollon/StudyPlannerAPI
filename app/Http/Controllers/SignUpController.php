<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    
    public function index()
    {
        //
    }

    
    public function store(Request $request)
    {
        //mao ni ang validator pasabot ni Sir nga naa dapat sa tanan API
        $validator = Validator::make($request->all(), [
            'fname' => 'required' ,
            'lname' => 'required' ,
            'email' => 'required|email|unique:users,email' ,
            'password' => 'required|min:8' ,
        ]);
        
        if($validator->fails()){
            $errors = $validator -> errors();

            $err = array(
                'fname' => $errors -> first('fname'),
                'lname' => $errors -> first('lname'),
                'email' => $errors -> first('email'),
                'password' => $errors -> first('password'),
            );

            return response() -> json(array(
                'message' => 'Cannot process request. Check input',
                'errors' => $err
            ),422);
        }


        $user = new User;
        $user -> fname = $request->input('fname');
        $user -> lname = $request->input('lname');
        $user -> email = $request->input('email');
        $user -> password = Hash::make($request->input('password'));
        $user -> save();

        return response() -> json(array(
            'message' => 'Registration Successful',
            'user' => $user
        ), 201 );
    }

   
    public function show($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
