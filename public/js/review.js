var app = angular.module('review', [], function($interpolateProvider){
	$interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});

app.controller('ReviewController', function($scope, $http){

	$scope.review = {};
	$scope.review.id = $("#id").val();
	$scope.review.user_id = $("#user_id").val();
	$scope.rating_enable = $("#rating").val();



	$scope.ups = function(){

		if($scope.rating_enable == true){
			id = $scope.review.id;
			user_id = $scope.review.user_id;

			postData = {
				id: id,
				user_id: user_id
			}

			$http({
				url: '../reviews/ups',
				method: 'POST',
				data: postData,
				headers: {'Content-Type': 'application/json'}
			}).success(function(){
				$scope.review.ups++;
			});	
		}
	};

	$scope.downs = function(){

		if($scope.rating_enable == true){
			id = $scope.review.id;
			user_id = $scope.review.user_id;

			postData = {
				id: id,
				user_id: user_id
			}

			$http({
				url: '../reviews/downs',
				method: 'POST',
				data: postData,
				headers: {'Content-Type': 'application/json'}
			}).success(function(){
				$scope.review.downs++;
			});	
		}
	};

});