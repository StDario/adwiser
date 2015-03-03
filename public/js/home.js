var app = angular.module('home', ['ngRoute','ui.router', 'ngAnimate', 'ui.bootstrap'], function($interpolateProvider){
	$interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});



app.controller('UserController', function($scope, $rootScope, $http, $location){

	$scope.questions_active = "active";
	$scope.reviews_active = "not";

	$rootScope.reviewsLoaded = false;
	$rootScope.questionsLoaded = false;
	$rootScope.questions = [];
	$rootScope.reviews = [];


	$scope.quickSuccess = false;

	$scope.redirect = function($path){

		$location.path("/" + $path);

		if($path == "questions"){
			$scope.questions_active = "active";
			$scope.reviews_active = "not";
		}
		else {
			$scope.questions_active = "not";
			$scope.reviews_active = "active";
		}
	}


	$scope.quickSubmit = function(){

		postData = {
			title: $scope.quick.title,
			text: $scope.quick.question_text
		}
		$http({
				url: '/questions/store',
				method: 'POST',
				data: postData,
				headers: {'Content-Type': 'application/json'}
			}).success(function(){
				$scope.quickSuccess = true;
			});	

	};


	$scope.$on('change_class_question', function(){
		$scope.questions_active = "active";
		$scope.reviews_active = "not";
	});

	$scope.$on('change_class_review', function(){
		$scope.questions_active = "not";
		$scope.reviews_active = "active";
	});

	//loadData();
});



app.factory('questionPoolingService', function($http){
	return {
		checkForNewQuestions: function(date){
			return $http.get('../../../questions/checknewdata/' + date).
			then(function(result){
				return result;
			});
		}
	}
});

app.factory('reviewPoolingService', function($http){
	return {
		checkForNewReviews: function(date){
			return $http.get('../../../reviews/checknewdata/' + date).
				then(function(result){
					return result;
				});
		}
	}
});

app.controller('QuestionController', function($scope, $rootScope, $timeout, questionService, questionPoolingService, questionNewDataService){

	$scope.questions = [];
	$scope.date = new Date(new Date() - 60 * 60000);
	$scope.check = "false";

	

	loadData = function(){
		$scope.questions = questionService.getQuestions().then(function(questions){
			$scope.questions = questions;
			$rootScope.questions = $scope.questions;
			console.log($rootScope.questions);
		});
	}


	getNewData = function(){
		newQ = questionNewDataService.getNewData($scope.date).then(function(questions){
			questions.forEach(function(entry){
						$scope.questions.unshift(entry);
						console.log(entry);
					});
			$rootScope.questions = $scope.questions;
		});

		
	}

	$scope.intervalFunction = function(){
	    $timeout(function() {
	      
	      questionPoolingService.checkForNewQuestions($scope.date).then(function(ret){
	      	$scope.check = ret.data;
	      });
	      
	      
	     
	      if($scope.check == "true"){
	      	getNewData($scope.date);
	      }
	      $scope.date = new Date(new Date() - 60 * 60000 - 10000);
	      $scope.intervalFunction();
	    }, 10000)
	  };

	  // Kick off the interval
	  $scope.intervalFunction();
	  if($rootScope.questionsLoaded == false){
	  	$rootScope.questionsLoaded = true;
	  	loadData();
	  }
	  else {
	  	console.log($rootScope.questions);
	  	$scope.questions = $rootScope.questions;
	  }

	$scope.$emit('change_class_question');

	//loadData();

	$scope.expandAdvice = function(id){		

		visible = $("#show_" + id).val();
		
		if(visible == "false"){
			$("#advice_" + id).show('blind', 800);
			$("#show_" + id).val("true");
		}
		else {
			$("#advice_" + id).hide('blind', 800);	
			$("#show_" + id).val("false");
		}
		//$("#advice" + id).switchClass("show-advices", "hide-advices", 1000);
	}

});

app.controller('ReviewController', function($scope, $rootScope, $timeout, reviewService, reviewPoolingService, reviewNewDataService){

	$scope.reviews = [];
	$scope.date = new Date(new Date() - 60 * 60000);
	$scope.check = "false";

	loadData = function(){
		$scope.reviews = reviewService.getReviews().then(function(reviews){
			$scope.reviews = reviews;
			$rootScope.reviews = $scope.reviews;
			console.log($rootScope.questions);
		});
	}


	getNewData = function(){
		newQ = reviewNewDataService.getNewData($scope.date).then(function(reviews){
			reviews.forEach(function(entry){
						$scope.reviews.unshift(entry);
						console.log(entry);
					});
			$rootScope.reviews = $scope.reviews;
		});

		
	}

	$scope.intervalFunction = function(){
	    $timeout(function() {
	      
	      reviewPoolingService.checkForNewReviews($scope.date).then(function(ret){
	      	$scope.check = ret.data;
	      });
	      
	      
	     
	      if($scope.check == "true"){
	      	getNewData($scope.date);
	      }
	      $scope.date = new Date(new Date() - 60 * 60000 - 10000);
	      $scope.intervalFunction();
	    }, 10000)
	  };

	  // Kick off the interval
	  $scope.intervalFunction();
	  if($rootScope.reviewsLoaded == false){
	  	$rootScope.reviewsLoaded = true;
	  	loadData();
	  }
	  else {
	  	console.log($rootScope.reviews);
	  	$scope.reviews = $rootScope.reviews;
	  }

	$scope.$emit('change_class_review');
});


app.factory('reviewService', function($http){
	return {
		getReviews: function(){
			return $http.get('../../../allreviews').
			then(function(result){
				return result.data;
			});
		}
	}
});

app.factory('questionService', function($http){
	return {
		getQuestions: function(){
			return $http.get('../../../allquestions').
			then(function(result){
				return result.data;
			});
		}
	}
});

app.factory('questionNewDataService', function($http){
	return {
		getNewData: function(date){

	      	console.log(date);
			return $http.get('../../../questions/getnewdata/' + date).
			then(function(result){
				console.log(result);
				return result.data;
			});
		}
	}
});

app.factory('reviewNewDataService', function($http){
	return {
		getNewData: function(date){
			return $http.get('../../../reviews/getnewdata/' + date).
				then(function(result){
					return result.data;
				});
		}
	}
})

app.config(function($stateProvider, $urlRouterProvider){

	$urlRouterProvider.otherwise("/questions");

	$stateProvider
	    .state('questions', {
	      url: "/questions",
	      templateUrl: "../questions",
	      controller: 'QuestionController'
	    })
	    .state('reviews', {
	      url: "/reviews",
	      templateUrl: "../reviews",
	      controller: 'ReviewController'
	    })
});

