<?php

Auth::routes();

Route::get('/category/{title?}', 'BlogsController@order')->name('blogs.order1');

Route::get('/', 'BlogsController@order')->name('blogs.order');
Route::get('post/{id}', 'BlogsController@show')->name('blogs.show');

Route::get('post', 'BlogsController@create')->name('blogs.create')->middleware('auth');
Route::post('post', 'BlogsController@store')->name('blogs.store')->middleware('auth');
Route::post('comments', 'CommentsController@store')->name('comments.store')->middleware('auth');
Route::delete('comments/{id}', 'CommentsController@destroy')->name('comments.destroy')->middleware('auth');

Route::get('profile/', 'UsersController@show')->name('profile')->middleware('auth');
Route::put('profile/update', 'UsersController@update')->name('profile.update')->middleware('auth');
Route::put('profile', 'UsersController@avatar')->name('add.profile.photo')->middleware('auth');
Route::get('profile/{user}', 'UsersController@show1')->name('profile.user');

Route::get('/search/', 'BlogsController@search')->name('blogs.search');
Route::get('/category/{title}/search/', 'BlogsController@search')->name('blogs.search1');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
    Route::get('category/create', 'CategoriesController@create')->name('category.create');
    Route::post('category', 'CategoriesController@store')->name('category.store');
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function() {
    Route::get('categorylist', 'CategoriesController@index')->name('category.index');
    Route::put('category/{id}', 'CategoriesController@update')->name('category.update');
    Route::delete('category/{id}', 'CategoriesController@destroy')->name('category.destroy');
    Route::get('users', 'UsersController@index')->name('admin-users');

    Route::put('store/{id}', 'UsersController@store')->name('user.store');
    Route::delete('destroy/{id}', 'UsersController@destroy')->name('user.destroy');

    Route::get('post/{id}/edit', 'BlogsController@edit')->name('blogs.edit');
    Route::delete('post/{id}', 'BlogsController@destroy')->name('blogs.destroy');
    Route::put('post/{id}', 'BlogsController@update')->name('blogs.update');
});

