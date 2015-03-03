var app = angular.module('searchResults', ['ngRoute','ui.router', 'ngAnimate'], function($interpolateProvider){
	$interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});


app.controller('SearchController', function($scope, $location){

	$scope.questions_active = "active";
	$scope.reviews_active = "not";


	$scope.questionsActive = function(){
		$scope.questions_active = "active";
		$scope.reviews_active = "not";
	}

	$scope.reviewsActive = function(){
		$scope.questions_active = "not";
		$scope.reviews_active = "active";
	}

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

/*


app.config(function($stateProvider, $urlRouterProvider){

	$urlRouterProvider.otherwise("/questions");

	$stateProvider
	    .state('questions', {
	      url: "/questions",
	      templateUrl: "../questions/show-search"
	    })
	    .state('reviews', {
	      url: "/reviews",
	      templateUrl: "../reviews/show-search"
	    })
});*/