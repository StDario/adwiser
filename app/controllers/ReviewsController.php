<?php

class ReviewsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('reviews.index');
	}

	public function allReviews(){
		//$data = Review::all();
		
		if(Auth::check())
			$data = Review::where('user.user_id', '<>', Auth::user()->_id)->get();
		else 
			$data = Review::all();

		return $data;
	}

	public function checkNewData($date){
		
		$date = substr($date, 4, 20);
		$date = date_create_from_format('M d Y H:i:s', $date);
		
		if(Auth::check())
			$reviews = Review::where('created_at', '>', $date)->where('user.user_id', '<>', Auth::user()->_id)->get();
		else 
			$reviews = Review::where('created_at', '>', $date)->get();

		if(count($reviews) > 0)
			return "true";
		return "false";
	}

	public function getNewData($date){
		$date = substr($date, 4, 20);
		$date = date_create_from_format('M d Y H:i:s', $date);
		
		if(Auth::check())
			$reviews = Review::where('created_at', '>', $date)->where('user.user_id', '<>', Auth::user()->_id)->get();
		else
			$reviews = Review::where('created_at', '>', $date)->get();

		return $reviews;
	}

	public function waitNewData($date){
		$time = time();
		$date = substr($date, 4, 20);
		$date = date_create_from_format('M d Y H:i:s', $date);

		while(true){
			$reviews = Review::where('created_at', '>', $date)->get();
			if(count($reviews) == 0){
				sleep(5);
			}
			else {
				return "true";
			}
			if(time() - $time > 20)
				return "false";
			
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('reviews.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$review = new Review;

		if(isset(Auth::user()->facebookID)){
			$review->user = array(
				'user_id' => Auth::user()->_id,
				'username' => Auth::user()->username,
				'facebook_id' => Auth::user()->facebookID
			);
		}
		else {
			$review->user = array(
				'user_id' => Auth::user()->_id,
				'username' => Auth::user()->username,
				'image_url' => Auth::user()->image_url
			);
		}
		$review->title = Input::get('title');
		$review->text = Input::get('text');
		$review->ups = 0;
		$review->downs = 0;

		$inputTags = Input::get('sendTags');

		$tags = array_filter(explode(";", $inputTags));
		

		$review->tags = $tags;
		$review->save();

		return Redirect::to('home');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$review = Review::find($id);

		$user_id = Auth::user()->_id;

		$rating_enable = true;

		if(isset($review->rated)){
			if(array_search($user_id, $review->rated) !== FALSE)
				$rating_enable = false;
		}
        return View::make('reviews.show')
        	->with('review', $review)
        	->with('rating_enable', $rating_enable);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('reviews.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function ups(){

		$id = Input::get('id');
		$user_id = Input::get('user_id');

		
		$review = Review::find($id);

		$review->ups = $review->ups + 1;

		if(isset($review->rated)){
			//array_push($review->rated, $user_id);
			$review->push('rated', $user_id);
		}
		else {
			$review->rated = array($user_id);
		}

		$review->save();
	}

	public function downs(){

		$id = Input::get('id');
		$user_id = Input::get('user_id');

		
		$review = Review::find($id);

		$review->downs = $review->downs + 1;

		if(isset($review->rated)){
			array_push($review->rated, $user_id);
		}
		else {
			$review->rated = array($user_id);
		}

		$review->save();
	}

}
