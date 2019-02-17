<?php




Route::group(['prefix' => 'v1'], function () {
   
    // get all books
    Route::get('books', 'BooksController@index')->name('books.all');
    // get detail book
    Route::get('book/{id}', 'BooksController@show')->name('books.detail');

    Route::group(['middleware' => 'jwt'], function () {
         
        // create a book
        Route::post('book', 'BooksController@store')->name('books.create');

        //show edit book
        Route::get('book/edit/{id}', 'BooksController@edit')->name('books.edit');
        
        // update a book
        Route::put('book/update', 'BooksController@update')->name('books.update');
        
        // delete a book
        Route::delete('book/{id}', 'BooksController@destroy')->name('books.delete');
    });

    // get all book by category
    Route::get('books/category/{id}', 'CategoriesController@getAllBookBycategory');

    // get all category
    Route::get('categories', 'CategoriesController@getAllCategory');

    Route::group([

        'middleware' => 'api',
        'prefix' => 'auth'
    
    ], function ($router) {
    
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    
    });


});

