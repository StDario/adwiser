var app = angular.module('advice', [], function($interpolateProvider){
	$interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});

app.controller('AdviceController', function($scope, $http){

	$scope.advice = {};
	$scope.advice.id = $("#id").val();
	$scope.advice.user_id = $("#user_id").val();
	$scope.rating_enable = $("#rating").val();


	$scope.adviceUps = function(){

		if($scope.rating_enable == true){
			id = $scope.advice.id;
			user_id = $scope.advice.user_id;

			postData = {
				id: id,
				user_id: user_id
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

		if($scope.rating_enable == true){
			id = $scope.advice.id;
			user_id = $scope.advice.user_id;

			postData = {
				id: id,
				user_id: user_id
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