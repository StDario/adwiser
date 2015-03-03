var app = angular.module('tags', [], function($interpolateProvider){
	$interpolateProvider.startSymbol('{');
    $interpolateProvider.endSymbol('}');
});


app.controller('TagController', function($scope){

	$scope.selectedTags = [];
	$scope.sendTags = "";

	enterTag = function(tag){
		$scope.$apply(function(){
			if($.inArray(tag, $scope.selectedTags) === -1){
				$scope.sendTags += tag + ";";
				$scope.selectedTags.push(tag);
			}
		});
	}


});

app.factory('tagsCompleteDataService', function($http) {
    return {
        getTags: function() {
            //this is where you'd set up your source... could be an external source, I suppose. 'something.php'
            tags = [];

			$http(
				{
					method: 'GET', 
					url: '../tags'
				}
			).success(function(data, status, headers, config) {

					data.forEach(function(entry){
						tags.push(entry.name);
					});
					return tags;
				});

			return tags;
        }
    }
});

app.directive('tagsComplete', function($http) {
    return {
        restrict: 'A',
        link: function(scope, elem, attr, ctrl) {
                    // elem is a jquery lite object if jquery is not present,
                    // but with jquery and jquery ui, it will be a full jquery object.
            elem.autocomplete({
                //source: tagsCompleteDataService.getTags(), //from your service
                
                source: function (request, response) {
               	 var url = "../tags/" + request.term;
               	 $http.get(url).success( function(data) {
               	 		tags = [];
               	 		data.forEach(function(entry){
							tags.push("#" + entry.name);
						});
						console.log(tags);
						response(tags);
                	});
            	},
                minLength: 2,
                select: function(event, ui){
                	enterTag(ui.item.label);
                }
            });
        }
    };
});

/*
app.controller('TagController', function($scope, $http){


	getTags = function(){

		tags = [];

		$http(
			{
				method: 'GET', 
				url: '../tags'
			}
		).success(function(data, status, headers, config) {

				data.forEach(function(entry){
					tags.push(entry.name);
				});
				return tags;
			});


		return tags;
	}

	$("#search-tags").autocomplete({
	      source: getTags()
	});

});*/

