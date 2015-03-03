<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('tags/{search}', 'HomeController@getTags');

Route::get('logout', function(){
	Auth::logout();
	return View::make('index');
});

Route::get('/', function()
{

	if(Auth::check())
		return View::make('user.home');
	return View::make('index');
});

Route::get('terms', function(){
	return View::make('home.terms');
});


Route::get('about', function(){
	return View::make('home.about');
});


Route::get('contact', function(){
	return View::make('home.contact');
});

Route::get('privacy', function(){
	return View::make('home.privacy');
});

Route::get('signup', function(){
	return View::make('home.signup');
});

Route::post('signup', 'UserController@signup');

Route::get('home', function(){
	return View::make('user.home');
});

Route::get('home/questions', function(){
	return View::make('user.home');
});

Route::get('home/reviews', function(){
	return View::make('user.home');
});

Route::get('users/loginfacebook', 'UserController@loginFacebook');

Route::get('users/logintwitter', 'UserController@loginTwitter');

Route::get('users/logingoogle', 'UserController@loginGoogle');

Route::get('profile', 'UserController@profile');

Route::get('questions/show-search', function(){
	return View::make('questions.show-search');
});

Route::resource('questions', 'QuestionsController');

Route::resource('advices', 'AdvicesController');

Route::resource('reviews', 'ReviewsController');

Route::get('allreviews', 'ReviewsController@allReviews');

Route::get('allquestions', 'QuestionsController@allQuestions');

Route::post('questions/store', 'QuestionsController@store');

Route::post('reviews/store', 'ReviewsController@store');

Route::post('advices/store', 'AdvicesController@store');

Route::resource('users', 'UserController');

Route::get('reviews/show-search', function(){
	return View::make('reviews.show-search');
});

Route::post('reviews/ups', 'ReviewsController@ups');

Route::post('reviews/downs', 'ReviewsController@downs');

Route::post('questions/ups', 'QuestionsController@ups');

Route::post('questions/downs', 'QuestionsController@downs');

Route::post('advices/ups', 'AdvicesController@ups');

Route::post('advices/downs', 'AdvicesController@downs');

Route::post('users/login', 'UserController@login');

Route::post('users/register', 'UserController@register');

Route::get('search/{search}', 'HomeController@search');

Route::get('search-tags/{tag}', 'HomeController@searchTags');

Route::get('search-result', 'HomeController@searchResult');

Route::get('advices/create/{question_id}', 'AdvicesController@create');

Route::get('questions/checknewdata/{date}', 'QuestionsController@checkNewData');

Route::get('questions/getnewdata/{date}', 'QuestionsController@getNewData');

Route::get('reviews/checknewdata/{date}', 'ReviewsController@checkNewData');

Route::get('reviews/getnewdata/{date}', 'ReviewsController@getNewData');

Route::get('reviews/waitnewdata/{date}', 'ReviewsController@waitNewData');

Route::get('advices/approve/{question_id}/{id}', 'AdvicesController@approve');