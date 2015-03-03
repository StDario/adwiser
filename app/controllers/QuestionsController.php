<?php

class QuestionsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('questions.index');
	}

	public function allQuestions(){
		//$data = Question::all();

		if(Auth::check())
			$data = Question::where('user.user_id', '<>', Auth::user()->_id)->get();
		else 
			$data = Question::all();

		//$data = Question::whereNotIn('user.user_id', array(Auth::user()->_id))->get();

		foreach ($data as $question) {
			if(isset($question->advices)){
				$question->advices = $this->getTopAdvices($question->advices);
			}
			//var_dump($question->advces);
		}
		//var_dump($data);
		return $data;
	}

	public function checkNewData($date){
		
		$date = substr($date, 4, 20);
		$date = date_create_from_format('M d Y H:i:s', $date);
		

		if(Auth::check())
			$questions = Question::where('created_at', '>', $date)->where('user.user_id', '<>', Auth::user()->_id)->get();
		else 
			$questions = Question::where('created_at', '>', $date)->get();
		if(count($questions) > 0)
			return "true";
		return "false";
	}

	public function getNewData($date){
		$date = substr($date, 4, 20);
		$date = date_create_from_format('M d Y H:i:s', $date);
		
		if(Auth::check())
			$questions = Question::where('created_at', '>', $date)->where('user.user_id', '<>', Auth::user()->_id)->get();
		else 
			$questions = Question::where('created_at', '>', $date)->get();
		return $questions;
	}

	function getTopAdvices($advices){
		$top = array();
		$approved = array();
		$pending = array();

		foreach ($advices as $advice) {
			if($advice['approved'] == true)
				$approved[] = $advice;
			else 
				$pending[] = $advice;
		}

		uksort($approved, array("QuestionsController", "compareAdvice"));

		$count = 0;
		foreach ($approved as $item) {
			
			$top[] = $item;
			$count++;
			if($count == 3)
				return $top;
		}

		uksort($pending, array("QuestionsController", "compareAdvice"));

		foreach ($pending as $item) {
			
			$top[] = $item;
			$count++;
			if($count == 3)
				return $top;
		}

		return $top;
	}

	public function compareAdvice($a, $b){
		if(($a['ups'] - $a['downs']) >= ($b['ups'] - $b['downs']))
			return 1;
		return -1;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('questions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$question = new Question;

		$question->title = Input::get('title');
		$question->text = Input::get('text');
		$question->ups = 0;
		$question->downs = 0;
		$question->active = true;


		$sendTags = Input::get('sendTags');
		if(isset($sendTags)){
			$sendTags = str_replace("#", "", $sendTags);
			$tags = array_filter(explode(";", $sendTags));
			$question->tags = $tags;
		}
		else 
			$question->tags = array();
		if(isset(Auth::user()->facebookID)){
			$question->user = array(
				'user_id' => Auth::user()->_id,
				'username' => Auth::user()->username,
				'facebook_id' => Auth::user()->facebookID
			);
		}
		else {
			$question->user = array(
				'user_id' => Auth::user()->_id,
				'username' => Auth::user()->username,
				'image_url' => Auth::user()->image_url
			);
		}

		$question->save();

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

		$question = Question::find($id);

		if(Auth::check())
			$user_id = Auth::user()->_id;

		$rating_enable = true;

		if(!isset($user_id))
			$rating_enable = false;
		else if(isset($question->rated)){
			if(array_search($user_id, $question->rated) !== FALSE)
				$rating_enable = false;
		}

		$advices = $question->advices;
		
		$length = count($advices);
		for($i = 0; $i < $length; $i++){
			if(!isset($user_id))
				$advices[$i]["rating_enable"] = false;
			else { 
				$advices[$i]["rating_enable"] = true;
				if(isset($advices[$i]->rated)){
					if(array_search($user_id, $advices[$i]->rated) !== FALSE)
						$advices[$i]["rating_enable"] = false;
				}
			}

		}
		$question->advices = $advices;
	
		
        return View::make('questions.show')
        	->with('question', $question)
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
        return View::make('questions.edit');
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

		
		$question = Question::find($id);

		$question->ups = $question->ups + 1;

		if(isset($question->rated)){
			//array_push($question->rated, $user_id);
			$question->push('rated', $user_id);
		}
		else {
			$question->rated = array($user_id);
		}

		$question->save();
	}

	public function downs(){

		$id = Input::get('id');
		$user_id = Input::get('user_id');

		
		$question = Question::find($id);

		$question->downs = $question->downs + 1;

		if(isset($question->rated)){
			array_push($question->rated, $user_id);
		}
		else {
			$question->rated = array($user_id);
		}

		$question->save();
	}

}
