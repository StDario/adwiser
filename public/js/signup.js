var app = angular.module('signup', ['ui.bootstrap']);

app.controller('SignUpController', function($scope){

	$scope.errorPassword = false;

	$scope.open = function($event) {
	    $event.preventDefault();
	    $event.stopPropagation();

	    $scope.opened = true;
	  };


	  $scope.submit = function($event){

	  	valid = true;

	  	if($scope.username.length < 4){
	  		valid = false;
	  		$scope.usernameMinLength = true;
	  		$scope.usernameMaxLength = false;
	  	}
	  	else {
	  		$scope.usernameMinLength = false;
	  	}

	  	if($scope.username.length > 25){
	  		valid = false;
	  		$scope.usernameMaxLength = true;
	  		$scope.usernameMinLength = false;
	  	}
	  	else {
	  		$scope.usernameMaxLength = false;
	  	}

	  	if($scope.password != $scope.password_confirm){
	  		valid = false;
	  		$scope.errorConfirmPassword = true;
	  	}
	  	else {
	  		$scope.errorConfirmPassword = false;
	  	}

	  	var passwd=  [/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/];  
	  	if($scope.password.match(passwd)){
	  		valid = false;
	  		$scope.errorFormatPassword = true;
	  	} else {
	  		$scope.errorFormatPassword = false;
	  	}

	  	if(valid == false){
		  		
	  		$event.preventDefault();
	 		$event.stopPropagation();

	  	}

	  }
});