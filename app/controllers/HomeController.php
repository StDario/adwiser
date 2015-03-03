<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function getTags($search){
		if($search == "all"){
			//$data = Tag::all();

			$result = DB::command(
				[
					"aggregate" => "questions",
					"pipeline" => [
						[
							'$project' => [ "tags" => 1 ]
						],
						[
							'$unwind' => '$tags'
						],
						[
							'$group' => [
								"_id" => '$tags',
								"count" => [ '$sum' => 1 ]
							]
						],
						[
							'$sort' => [ 'count' => -1 ]
						]
					]
				]
			);
			$result = $result["result"];
			$data = array();
			$length = count($result);

			for($i = 0; $i < $length; $i++){
				$data[$i] = $result[$i]['_id'];
				if($i > 15)
					break;
			}
			
		}
		else {
			$data = Tag::where('name', 'like', "%$search%")->get();
		}
		return $data;
	}

	public function searchTags($tag){
		$questions = Question::where('tags', 'all', array($tag))->get();
		$reviews = Review::where('tags', 'all', array($tag))->get();

		return View::make('user.search')
			->with('questions', $questions)
			->with('reviews', $reviews);
	}

	public function searchResult(){
		$search = Input::get('search-input');


		if(strpos($search, "#") === 0){

			$tag = substr($search, 1, strlen($search));
			$questions = Question::where('tags', 'all', array($tag))->get();
			$reviews = Review::where('tags', 'all', array($tag))->get();

			return View::make('user.search')
				->with('questions', $questions)
				->with('reviews', $reviews);
		}
		
		$reviews = Review::where('title', 'like', "%$search%")->orWhere('text', 'like', "%$search%")->get();
		$questions = Question::where('title', 'like', "%$search%")->orWhere('text', 'like', "%$search%")->get();

		return View::make('user.search')
			->with('questions', $questions)
			->with('reviews', $reviews);
	}

	public function search($search){
		
		$reviews = Review::where('title', 'like', "%$search%")->get();
		$questions = Question::where('title', 'like', "%$search%")->get();
		$tags = Tag::where('name', 'like', "%$search%")->get();

		$data = array();
		$countTag = count($tags);
		$countQuestion = count($questions);
		$countReview = count($reviews);

		$t = 0;
		$q = 0;
		$r = 0;
		$count = 0;
		$first = true;
		
		while(true){
			$add = false;
			if($first){
				$range = 3;
				$tRange = 2;
				$first = false;
			}
			else 
				$range = $tRange = 1;

			for($i = $q; $i < $q + $range; $i++){
				if($i < $countQuestion && $count < 8){
					$data[] = array("category" => "q", "value" => array("title" => $questions[$i]->title,"id" => $questions[$i]->_id ));
					$add = true;
					$count++;
				}
				else 
					break;
			}
			$q += $i;

			for($i = $r; $i < $r + $range; $i++){
				if($i < $countReview && $count < 8){
					$data[] = array("category" => "r", "value" => array("title" => $reviews[$i]->title,"id" => $reviews[$i]->_id ));
					$count++;
					$add = true;
				}
				else 
					break;
			}
			$r += $i;

			for($i = $t; $i < $t + $tRange; $i++){
				if($i < $countTag && $count < 8){
					$data[] = array("category" => "t", "value" => array("title" => $tags[$i]->name,"id" => $tags[$i]->name ));
					$count++;
					$add = true;
				}
				else 
					break;
			}

			$t += $i;

			if($add == false || ($t + $q + $r) == 8)
				break;
		}

		return $data;
	}
}