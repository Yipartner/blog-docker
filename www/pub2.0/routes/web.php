<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'HomeController@homepage');
Route::get('/home', 'HomeController@homepage');

Auth::routes();

Route::get('/article', 'HomeController@index');
Route::get('/article/type/{typeId}','ArticleController@showArticlesByType');
Route::get('/article/tag/{tagId}','ArticleController@showArticlesByTag');
Route::get('/article/content/{articleId}','ArticleController@showArticleById');


Route::get('/article/delete/{articleId}','ArticleController@deleteArticle')->middleware('admin');


Route::get('/article/edit/{articleId}','ArticleController@editView')->middleware('admin');
Route::get('/article/create',function (){
    return view('article.create',[
        'article' => '',
        'do'=>'create'
    ]);
})->middleware('admin');



Route::post('/article','ArticleController@createNewArticle')->middleware('admin');
Route::post('/article/edit','ArticleController@editArticle')->middleware('admin');



Route::get('/tags','TagController@getTags');


Route::get('/dashboard',function (){
    return view('dashboard');
});
Route::get('/dashboard/type',function (){
    return view('admin.type');
});


Route::get('/type/delete/{typeId}','TypeController@deleteType');
Route::post('type','TypeController@addType');