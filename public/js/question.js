var app = angular.module('question', [], function($interpolateProvider){
	$interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});

app.controller('QuestionController', function($scope, $http){

	$scope.question = {};
	$scope.question.id = $("#id").val();
	$scope.question.user_id = $("#user_id").val();
	$scope.rating_enable = $("#rating").val();



	$scope.ups = function(){

		//if($scope.rating_enable == true){
			id = $scope.question.id;
			user_id = $scope.question.user_id;

			postData = {
				id: id,
				user_id: user_id
			}

			$http({
				url: '../questions/ups',
				method: 'POST',
				data: postData,
				headers: {'Content-Type': 'application/json'}
			}).success(function(){
				$scope.question.ups++;
			});	
		//}
	};

	$scope.downs = function(){

		if($scope.rating_enable == true){
			id = $scope.question.id;
			user_id = $scope.question.user_id;

			postData = {
				id: id,
				user_id: user_id
			}

			$http({
				url: '../questions/downs',
				method: 'POST',
				data: postData,
				headers: {'Content-Type': 'application/json'}
			}).success(function(){
				$scope.question.downs++;
			});	
		}
	};

});


app.controller('AdviceController', function($scope, $http){

	$scope.advice = {};
	$scope.advice.id = "";
	$scope.advice.question_id = $("#id").val();


	$scope.adviceUps = function(){
		if($scope.rating_enable_advice == true){
			id = $scope.advice.id;
			question_id = $scope.advice.question_id;

			postData = {
				id: id,
				question_id: question_id
			}
			
			$http({
				url: '../advices/ups',
				method: 'POST',
				data: postData,
				headers: {'Content-Type': 'application/json'}
			}).success(function(){
				$scope.advice.ups++;
			});	
		}
	};

	$scope.adviceDowns = function(){

		if($scope.rating_enable_advice == true){
			id = $scope.advice.id;
			question_id = $scope.advice.question_id;

			postData = {
				id: id,
				question_id: question_id
			}
			
			$http({
				url: '../advices/downs',
				method: 'POST',
				data: postData,
				headers: {'Content-Type': 'application/json'}
			}).success(function(){
				$scope.advice.downs++;
			});	
		}
	};

});

