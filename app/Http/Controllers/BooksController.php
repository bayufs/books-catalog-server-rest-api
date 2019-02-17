<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Books as BooksResources;
use App\Http\Resources\Book as BookResources;
use App\Books;
use Validator;
use File;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @return BooksResources
     */
    public function index()
    {
        $all_books = Books::orderBy('id', 'desc')->paginate(10);
        return BooksResources::collection($all_books);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $books = new Books;

        $validation = Validator::make($request->all(), [
            'title'       => 'required|string',
            'author'      => 'required|string|max:30',
            'image'       => 'required|mimes:jpeg,jpg,png,gif',
            'link'        => 'required|string',
            'featured'    => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required'
        ]);

        

        if ($validation->fails()) {
            $error_msg = [
                'msg' => 'Opps Terjadi error',
                'error' => $validation->errors()
            ];
            
            return response()->json($error_msg, 404);
        }


        $input = [
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'image' => $request->file('image')->getClientOriginalName(),
            'link' => $request->input('link'),
            'featured' => $request->input('featured'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
        ];

        

        if ($books->fill($input)->save()) {
            $image_name  = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($image_name, PATHINFO_FILENAME);
            $image_file  = $fileName.'.'.$request->image->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $image_file);
            
            return new BookResources($books);
        } else {
            return response()->json('Gagal Untuk Menambah Data', 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail_book = Books::find($id);
        if (is_null($detail_book)) {
            $error_msg = [
                'msg' => 'Data is no longger exist or data is not exist',
                'redirect' => route('books.all')
            ];
            return response()->json($error_msg, 404);
        } else {
            return new BookResources($detail_book);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Books::findOrFail($id);
        return new BookResources($edit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        $books = new Books;
    
        $validation = Validator::make($request->all(), [
            'title'       => 'required|string',
            'author'      => 'required|string|max:30',
            'image'       => 'mimes:jpeg,jpg,png,gif',
            'link'        => 'required|string',
            'featured'    => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required',
            'book_id'     => 'required'
        ]);


        if ($validation->fails()) {
            $error_msg = [
                'msg' => 'Opps Terjadi error',
                'error' => $validation->errors()
            ];
            
            return response()->json($error_msg, 404);
        }

        $input = [
            'title'        => $request->input('title'),
            'author'       => $request->input('author'),
            'image'        => $request->file('image')->getClientOriginalName(),
            'link'         => $request->input('link'),
            'featured'     => $request->input('featured'),
            'description'  => $request->input('description'),
            'category_id'  => $request->input('category_id'),
        ];

        
        $books = Books::find($request->input('book_id'));
        if (is_null($books)) {
            $error_msg = [
                'msg' => 'Data is no longger exist or data is not exist',
                'redirect' => route('books.all')
            ];
            return response()->json($error_msg, 404);
        }

        if ($books->fill($input)->save()) {
            $image_name  = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($image_name, PATHINFO_FILENAME);
            $image_file  = $fileName.'.'.$request->image->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $image_file);
            
            return new BookResources($books);
        } else {
            return response()->json('Gagal Untuk Merubah Data', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $books = Books::find($id);
        if (!is_null($books)) {
            if ($books->delete()) {
                $path = public_path('images/'.$books->image) ;
                File::delete($path);
                return new BookResources($books);
            }
        } else {
            $error_msg = [
                'msg' => 'Data is no longger exist or data is not exist',
                'redirect' => route('books.all')
            ];
            return response()->json($error_msg, 404);
        }
    }
}
