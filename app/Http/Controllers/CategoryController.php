<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('categories')
            //-> paginate(100) pila ka items sa isa ka page heheee
            -> select('id' , 'name')
            -> get();


        /*$categories = Category::all();
        return response() -> json($categories);*/
    }
}