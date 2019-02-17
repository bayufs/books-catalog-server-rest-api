<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CategoriesResources;
use App\Http\Resources\BooksByCategoryResources;
use App\Categories;
use App\Books;

class CategoriesController extends Controller
{
    public function getAllCategory()
    {
        return CategoriesResources::collection(Categories::orderBy('id','DESC')->get());
    }

    public function getAllBookBycategory($id)
    {
        return BooksByCategoryResources::collection(Books::where('category_id', $id)->orderBy('id', 'desc')->paginate(10));
    }
}
