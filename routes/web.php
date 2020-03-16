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

//Home/news - gets recent posts and outputs welcome page
Route::get('/', function () {
    $posts = App\Post::orderBy('created_at', 'desc')->take(5)->get();
    return view('welcome')->with('posts', $posts);
});
//Route::get('/', function () { return view('placeholder'); });

//Subpages
Route::get('/about', function() { return view('about'); });
Route::get('/assistance', function() { return view('assistance'); });
Route::get('/archive', function() { 
    $posts = App\Post::orderBy('created_at', 'desc')->get();
    return view('archive')->with('posts', $posts); 
});
Route::get('/posts/{id}', function($id) { 
    $post = App\Post::find($id);
    return view('post')->with('post', $post); 
});

Route::get('/notauthed', function() {
    return view('notauthed');
});

//Authentication routes
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/authorpost', function(){ return view('authorpost'); })->middleware('approved');
Route::get('/authorpost/{id}', function($id){
    $post = App\Post::find($id);
    return view('authorpost')->with('post', $post);
})->middleware('approved');
Route::post('/savepost/{id}', 'PostController@save')->middleware('approved');
Route::get('/deletepost/{id}', 'PostController@delete')->middleware('approved');
Route::get('/deletepostprompt/{id}', function($id) { return view('deleteprompt')->with('postid', $id); })->middleware('approved');

Route::get('/approveuser/{id}', function($id) { 
    $user = App\User::find($id);
    $user->role = 'poster';
    $user->save();
    return redirect('home');
})->middleware('approved');

Route::get('/approveadmin/{id}', function($id) { 
    $user = App\User::find($id);
    $user->role = 'admin';
    $user->save();
    return redirect('home');
})->middleware('approved');

Route::get('/declineuser/{id}', function($id) { 
    $user = App\User::find($id);
    $user->delete();
    return redirect('home');
});
