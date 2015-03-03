var app = angular.module('quickquestion', [], function($interpolateProvider){
	$interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});

app.controller('QuickQuestionController', function($scope, $http){


	$scope.quickSubmit = function(){
		date = new Date();
		console.log(date);
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
});

