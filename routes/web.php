<?php


Auth::routes();

Route::get('/category/{title}', 'BlogsController@order')->name('blogs.order1');

Route::get('/', 'BlogsController@order')->name('blogs.order');
Route::get('post/{id}', 'BlogsController@show')->name('blogs.show');

Route::get('profile/{user}', 'UsersController@show1')->name('profile.user');

Route::group(['middleware' => 'auth'], function() {
    Route::get('post', 'BlogsController@create')->name('blogs.create');
    Route::post('post', 'BlogsController@store')->name('blogs.store');
    Route::post('comments', 'CommentsController@store')->name('comments.store');
    Route::delete('comments/{id}', 'CommentsController@destroy')->name('comments.destroy');

    Route::get('profile/', 'UsersController@show')->name('profile')->middleware('auth');
    Route::put('profile/update', 'UsersController@update')->name('profile.update')->middleware('auth');
    Route::put('profile', 'UsersController@avatar')->name('add.profile.photo')->middleware('auth');

    Route::get('/search/', 'BlogsController@search')->name('blogs.search');
    Route::get('/category/{title}/search/', 'BlogsController@search')->name('blogs.search1');
});


// ADMIN Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('', 'AdminController@index')->name('dashboard');

    Route::get('categories', 'CategoriesController@create')->name('categories');
    Route::post('category', 'CategoriesController@store')->name('category.store');
    Route::put('category/{id}', 'CategoriesController@update')->name('category.update');
    Route::delete('category/{id}', 'CategoriesController@destroy')->name('category.destroy');

    Route::get('users', 'UsersController@index')->name('users');
    Route::put('users/{id}', 'UsersController@store')->name('user.store');
    Route::delete('users/{id}', 'UsersController@destroy')->name('user.destroy');
    Route::get('users/{id}/activity', 'UsersController@activity')->name('users.activity');

    Route::get('posts', 'BlogsController@posts')->name('posts');
    Route::get('post/{permalink}/edit', 'BlogsController@edit')->name('blogs.edit');
    Route::delete('post/{id}', 'BlogsController@destroy')->name('blogs.destroy');
    Route::put('post/{permalink}', 'BlogsController@update')->name('blogs.update');
});

