<?php

class AdvicesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('advices.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($question_id)
	{
		$question = Question::find($question_id);

		// $m = new MongoClient();
		// $db = $m->adwiser;
		// $collection = $db->questions;
		// $criteria = array('_id' => new MongoID($question_id));
		// $cursor = $collection->findOne($criteria);
		// optional
		// $question = (object)$cursor;

        return View::make('advices.create')
        	->with('question', $question);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$id = Input::get('question_id');
		$text = Input::get('text');
		$date = date('d-m-Y H:i:s', time());
		$question = Question::find($id);

		if(!isset($question->advices))
			$count = 0;
		else 
			$count = count($question->advices);
		$count++;

		if(isset(Auth::user()->facebookID)){
			$key = "facebook_id";
			$value = Auth::user()->facebookID;
		}
		else {
			$key = "image_url";
			$value = Auth::user()->image_url;
		}

		DB::collection('questions')->where('_id', $id)->push('advices',
			array(
				
					'_id' => $count,
					'user' => array(
						'user_id' => Auth::user()->_id,
						'username' => Auth::user()->username,
						$key => $value
					),
					'text' => $text,
					'ups' => 0,
					'downs' => 0,
					'created_at' => $date,
					'approved' => false
				)	
		);

		// $m = new MongoClient();
		// $db = $m->adwiser;
		// $collection = $db->questions;
		// $collection->update(
		// 	array("_id" => $id),
		// 		array( 
		// 		'$push' => array( "advices" => 
		// 			array(
		// 			'_id' => $count,
		// 			'user' => array(
		// 				'user_id' => Auth::user()->_id,
		// 				'username' => Auth::user()->username,
		// 				$key => $value
		// 			),
		// 			'text' => $text,
		// 			'ups' => 0,
		// 			'downs' => 0,
		// 			'created_at' => $date,
		// 			'approved' => false
		// 			))
		// 	));


		return Redirect::to("questions/$id");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('advices.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('advices.edit');
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

	/**
	 * Increment the up count of an advice.
	 *
	 * @return void
	 */
	public function ups(){
		$id = Input::get('id');
		$question_id = Input::get('question_id');

		$question = Question::find($question_id);

		$advices = array();
		foreach($question->advices as $advice){
			if($advice['_id'] == $id){
				$advice['ups']++;
				if(isset($advice['rated'])){
					array_push($advice['rated'], Auth::user()->_id);
				}
			}
			array_push($advices, $advice);
		}
		$question->advices = $advices;
		$question->save();
	}

	/**
	 * Increment the down count of an advice.
	 *
	 * @return void
	 */
	public function downs(){
		$id = Input::get('id');
		$question_id = Input::get('question_id');

		$question = Question::find($question_id);

		$advices = array();
		foreach($question->advices as $advice){
			if($advice['_id'] == $id){
				$advice['downs']++;
				if(isset($advice['rated'])){
					array_push($advice['rated'], Auth::user()->_id);
				}
			}
			array_push($advices, $advice);
		}
		$question->advices = $advices;
		$question->save();
	}

	/**
	 * Approve an advice.
	 *
	 * @param ObjectID $question_id, int $id
	 * @return void
	 */
	public function approve($question_id, $id){
		$question = Question::find($question_id);

		$advices = array();

		foreach($question->advices as $advice){
			if($advice['_id'] == $id){
				$advice['approved'] = true;
			}
			array_push($advices, $advice);
		}
		$question->advices = $advices;
		$question->save();
	}

}
