<?php

class UserController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('users.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		echo "zdravo";
		$data = Input::all();
		return $data;
        //return View::make('users.create');
	}

	public function profile(){
		$user = Auth::user();
		$questions = Question::where('user.user_id', '=', Auth::user()->_id)->get();
		$reviews = Review::where('user.user_id', '=', Auth::user()->_id)->get();
		

		foreach ($questions as $question) {
			if(isset($question->advices)){
				$question->advices = $this->getTopAdvices($question->advices);
			}
			//var_dump($question->advces);
		}

		return View::make('user.profile')
			->with('user', $user)
			->with('questions', $questions)
			->with('reviews', $reviews);
	}

	public function postCreate(){
		echo "zdraov";
		$data = Input::all();
		return $data;
	}

	public function compareAdvice($a, $b){
		if(($a['ups'] - $a['downs']) >= ($b['ups'] - $b['downs']))
			return 1;
		return -1;
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

		uksort($approved, array("UserController", "compareAdvice"));

		$count = 0;
		foreach ($approved as $item) {
			
			$top[] = $item;
			$count++;
			if($count == 3)
				return $top;
		}

		uksort($pending, array("UserController", "compareAdvice"));

		foreach ($pending as $item) {
			
			$top[] = $item;
			$count++;
			if($count == 3)
				return $top;
		}

		return $top;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		return $data;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('users.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('users.edit');
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

	public function login(){

		$username = Input::get('username');
		$password = Input::get('password');
		$remember = Input::get('remember');


		if(empty($remember))
			$remember = false;
		else 
			$remember = true;

		try { 
			$user = User::where('username','=',$username)->where('password', '=', $password)->firstOrFail();
			//Session::put('authenticated', 'true');
			//if($remember){
			//	Cookie::put('username', $username, 10800);
			//}

			Auth::login($user, $remember);
			
			return Redirect::to('home');
			//return View::make('user.home');
		}
		catch(Exception $e){
			return View::make('index')
				->with('error', 'Wrong username or password');
		}
		/*
		if(Auth::attempt(array('username' => $username, 'password' => $password), $remember)){
			echo "Najaven";
		}
		else 
			echo "Greska";*/
	}

	public function signup(){

		$fullname = Input::get('fullname');
		$username = Input::get('username-signup');
		$password = Input::get('password-signup');

		$firstname = "";
		$lastname = "";

		if(isset($fullname)){
			$names = explode(" ", $fullname);

			if(isset($names[0]))
				$firstname = $names[0];
			if(isset($names[1]))
				$lastname = $names[1];
		}
		
		$validator = Validator::make(Input::all(), array());


		return View::make('home.signup')
			->with('firstname', $firstname)
			->with('lastname', $lastname)
			->with('username', $username)
			->with('password', $password)
			->with('errors', $validator->messages());
	}

	public function register(){

		$rules = array(
				'username' => 'required|min:4|max:25|unique:users,username',
				'password' => 'required|min:8|confirmed',
				'name' => 'required',
				'lastname' => 'required',
				'email' => 'email',
				'gender' => 'required',
				'birthday' => 'date_format:d-m-Y',
				'image' => 'image'
		);

		
		$validator = Validator::make(Input::all(), $rules);

		$errors = $validator->messages();

		if($validator->fails()){
			return Redirect::back()
				->with('errors', $errors);
		}
		else {
			
			$user = new User;
			$user->username = Input::get('username');
			$user->password = Input::get('password');
			$user->name = Input::get('name');
			$user->lastname = Input::get('lastname');
			$user->email = Input::get('email');
			$user->gender = Input::get('gender');
			$user->birthday = Input::get('birthday');
			$user->save();

			$image = Input::file('image');

			if(isset($image)){
				$mime = Input::file('image')->getMimeType();
				$mime = explode('/',$mime);
				$mime = $mime[1];
				$imageName = $user->_id.'_'.time().'.'.$mime;
				

				Image::make(Input::file('image')->getRealPath())->resize(300, 200)->save(public_path().'/images/'.$imageName);
				Image::make(Input::file('image')->getRealPath())->resize(50, 50)->save(public_path().'/thumbnails/'.$imageName);	
			}
			else {
				$imageName = "user.jpg";
			}

			
			
			$user->image_url = $imageName;
			$user->save();

			Auth::login($user);

			return View::make('user.home');
		}
	}

	public function loginFacebook(){

		$code = Input::get('code');

		$fb = OAuth::consumer('Facebook');


		if(!empty($code)){

			$token = $fb->requestAccessToken($code);

			$result = json_decode($fb->request('/me'), true);


			$users = User::where('username', '=', $result['username'])->get();

			if(!isset($users) || count($users) == 0){
				$user = new User;
				$user->username = $result['username'];
				$user->name = $result['first_name'];
				$user->lastname = $result['last_name'];
				$user->email = $result['email'];
				$user->gender = $result['gender'];
				$user->birthday = $result['birthday'];
				$user->facebookID = $result['id'];
				$user->save();

				Auth::login($user);
			}
			else {
				Auth::login($users[0]);
			}
			return View::make('user.home');
		}
		else {
			$url =  $fb->getAuthorizationUri();
			return Redirect::to((string)$url);
		}
	}

	public function loginTwitter(){

		$oauth_token = Input::get('oauth_token');
	    $oauth_verifier = Input::get('oauth_verifier');
	    // get service
	    $twit = OAuth::consumer('Twitter');


	    // check if code is valid

	    // if code is provided get user data and sign in
	    if (!empty($oauth_token)) {

	        // This was a callback request from google, get the token
	        $token = $twit->requestAccessToken($oauth_token, $oauth_verifier);

	        // Send a request with it
	        $result = json_decode( $twit->request( 'account/verify_credentials.json' ), true );

	        echo print_r($result);

	    }
	    // if not ask for permission first
	    else {
	        // get authorization
	        //var_dump($twit);
	        //return;
	        $token = $twit->requestRequestToken();
	        $url = $twit->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));

	        // return to login url
	        return Redirect::to((string)$url);
	    }
	}

	public function loginGoogle() {

    // get data from input
    $code = Input::get( 'code' );

    // get google service
    $googleService = OAuth::consumer( 'Google' );

    // check if code is valid

    // if code is provided get user data and sign in
    if ( !empty( $code ) ) {

        // This was a callback request from google, get the token
        $token = $googleService->requestAccessToken( $code );

        // Send a request with it
        $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );
        

        $users = User::where('username', '=', $result['email'])->get();

		if(!isset($users) || count($users) == 0){
			$user = new User;
			$user->username = $result['email'];
			$user->name = $result['name'];
			$user->lastname = $result['family_name'];
			$user->email = $result['email'];
			$user->gender = $result['gender'];
			$user->googleID = $result['id'];
			$user->image_url = $result['picture'];
			$user->save();

			Auth::login($user);
		}
		else {
			Auth::login($users[0]);
		}
		return View::make('user.home');

    }
    // if not ask for permission first
    else {
        // get googleService authorization

        $url = $googleService->getAuthorizationUri();

        // return to facebook login url
        return Redirect::to((string)$url);
    }
}
}
