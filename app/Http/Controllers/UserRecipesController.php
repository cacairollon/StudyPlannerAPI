<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserRecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::find($id);

        if($user == NULL){
            return response() -> json(array(
                'message' => 'Error! User is not found'
            ), 404);
        }

        return $user -> recipes() -> paginate(2);



    }

}
