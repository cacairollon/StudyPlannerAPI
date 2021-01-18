<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
//use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function __construct(){
        $this -> middleware('jwt-check',['except' => ['index' , 'show']]);
        //ang index mao ning index sa ubos, bali mao ni ang recipecontroller
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Recipe::paginate(2);
        //bali kani sa ubos pwede ka mag pili kung unsa ra imo ipagawas heeheee
        /*return Recipe::select('id','name' ,'description', 'category_id')
            -> paginate(2); */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation below
        /*$validator = Validator::make($request->all(), [
            //'fname' => 'required' ,
            //'lname' => 'required' ,
            //'email' => 'required|email|unique:users,email' ,
            'email' => 'required|email|' ,
            'password' => 'required|min:8' ,
        ]);
        
        if($validator->fails()){
            $errors = $validator -> errors();

            $err = array(
                //'fname' => $errors -> first('fname'),
                //'lname' => $errors -> first('lname'),
                'email' => $errors -> first('email'),
                'password' => $errors -> first('password'),
            );

            return response() -> json(array(
                'message' => 'Cannot process request. Check input',
                'errors' => $err
            ),422);
        }
        
        */

        $recipe = new Recipe;
        $recipe -> name = $request -> input('name');
        $recipe -> user_id = auth('api') -> user('') -> id;
        $recipe -> description = $request -> input('description', NULL);
        $recipe -> category_id = $request -> input ('category');
        $recipe -> save();

        return response() -> json(array(
            'message' => 'Recipe added',
            'recipe' => $recipe

        ), 201 );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::find($id);
        if($recipe == NULL ){
            return response() -> json(array(
                'message' => 'Recipe is not found'
            ), 404);
        }
        return response() -> json($recipe);
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
        $recipe = Recipe::find($id);
        if($recipe == NULL ){
            return response() -> json(array(
                'message' => 'Recipe is not found'
            ), 404);
        }

        if($request -> has('name'))
            $recipe -> name = $request -> input('name');

        if($request -> has('description'))
            $recipe -> description = $request -> input('description');

        if($request -> has('category')) //if mag validation dapat makita kung ga exist bani
            $recipe -> category_id = $request -> input('category');

        $recipe -> save();

        return response() -> json(array(
            'message' => 'Recipe updated!'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        if($recipe == NULL ){
            return response() -> json(array(
                'message' => 'Recipe is not found'
            ), 404);
        }
        $recipe -> delete();

        return response() -> json(array(
            'message' => 'Recipe is deleted!'
        ));
    }
}
