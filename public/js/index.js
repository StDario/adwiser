
var app = angular.module('index', [], function($interpolateProvider){
	$interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});

app.controller('TagCtrl', function($scope, tagService){

	$scope.tags = [];

	loadData = function(){
		$scope.tags = tagService.getTags().then(function(tags){
			$scope.tags = tags;
		});
	}

	loadData();
});

app.factory('tagService', function($http){
	return {
		getTags: function(){
			return $http.get('../tags/all').
			then(function(result){
				return result.data;
			});
		}
	}
});
